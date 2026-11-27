---
title: "Contratto — SaveTenantConfigAction"
type: contract
action: "Modules\\Tenant\\Actions\\Config\\SaveTenantConfigAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# SaveTenantConfigAction

Persiste un file `config/<tenant>/<name>.php` fondendo i dati nuovi con quelli esistenti. Chiamata dalle pagine di impostazioni
(`Modules/Xot/app/Filament/Pages/MetatagPage.php`, `Modules/Cms/app/Filament/Clusters/Appearance/Pages/Breadcrumb.php`, le `*ConfigData` di Cms, Seo e Tenant)
e da `GetTenantModelClassAction`. Sorgente: `app/Actions/Config/SaveTenantConfigAction.php`.

## Input

- `string $name`: nome del file di config senza estensione (`database`, `xra`, `morph_map`...).
- `array<string, mixed> $data`: chiavi da scrivere, tipicamente lo stato di un form.

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-CONFIG-SAVE-INV-1 | Le chiavi associative si fondono in profondità: quelle non inviate restano, quelle inviate vincono (`arrayMergeRecursiveDistinct`). | `TENANT-CONFIG-SAVE-INV-1` |
| TENANT-CONFIG-SAVE-INV-2 | Una lista (`array_is_list`) inviata sostituisce per intero la vecchia: mai fusione per indice. Se cade, gli elementi tolti da un `TagsInput` ricompaiono. | `TENANT-CONFIG-SAVE-INV-2` |
| TENANT-CONFIG-SAVE-INV-3 | File assente o che non ritorna un array = si parte da `[]` e il file si crea. | `TENANT-CONFIG-SAVE-INV-3` |
| TENANT-CONFIG-SAVE-INV-4 | Il file si scrive sempre in `config/<tenant>/<name>.php` risolto da `GetTenantFilePathAction` (stessa difesa da traversal), con chiavi ordinate (`Arr::sortRecursive`). | — (non dimostrato) |
## Effetti collaterali

- Nell'ordine: risolve il percorso (`GetTenantFilePathAction`), legge il file esistente con `File::getRequire` (esegue il PHP che contiene), fonde, ordina, riscrive il file intero con `Modules\Xot\Actions\Arr\SaveArrayAction`.
- Nessuna transazione, evento o coda. La config in memoria non è aggiornata: il valore nuovo si vede dalla richiesta successiva.

## Errori

- `InvalidArgumentException` da `GetTenantFilePathAction` se `$name.'.php'` contiene traversal o è assoluto (INV-4).
- Errori di lettura/scrittura del filesystem e di `SaveArrayAction` si propagano.

## Non fa

- Non cancella chiavi: un valore si toglie solo sovrascrivendolo.
- Non valida i valori, non fa backup del file precedente e non gestisce scritture concorrenti: l'ultima vince.
- Non ricarica né invalida la cache di configurazione.

## Riconciliazione documentale (2026-11-27)

Questo file aveva un conflitto Git irrisolto. La base è la variante più recente del contratto, con il riferimento a `app/Actions/Config/SaveTenantConfigAction.php` **esistente su `dev`**; la sua semantica, i group Pest citati e gli eventuali effetti non sono stati rieseguiti in questa sessione. Il confronto con il codice e i test resta il gate ECC della story owner. [Tracciamento root #15](https://github.com/laraxot/base_ptvx_fila5/issues/15).
