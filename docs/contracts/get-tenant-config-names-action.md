---
title: "Contratto — GetTenantConfigNamesAction"
type: contract
action: "Modules\\Tenant\\Actions\\Config\\GetTenantConfigNamesAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# GetTenantConfigNamesAction

Sorgente: `app/Actions/Config/GetTenantConfigNamesAction.php`.

## Input

- Nessun parametro. Il tenant viene da `GetTenantNameAction`, la cartella da `config_path()` (corretta da `FixPathAction`).

## Output

- `array<int, array{id:int,name:string}>`: per ogni file `.php`, `name` senza estensione e `id` posizione 1-based.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-CFG-NAMES-INV-1 | Sono elencati solo file con estensione `php`; la ricerca non è ricorsiva (`File::files`). | `TENANT-CFG-NAMES-INV-1` |
| TENANT-CFG-NAMES-INV-2 | `id` è sequenziale da 1 nell'ordine restituito da `File::files`, che l'Action non ordina. | `TENANT-CFG-NAMES-INV-2` |
## Effetti collaterali

- Legge la cartella. Nessuna scrittura.

## Errori

- Nessuna gestione esplicita: se la cartella non esiste l'errore di `File::files` si propaga.

## Non fa

- Non legge il contenuto dei file e non ordina per nome: l'`id` può cambiare tra filesystem diversi.
- Non passa da `GetTenantFilePathAction`, quindi non applica il controllo anti-traversal: il nome tenant è considerato fidato.
