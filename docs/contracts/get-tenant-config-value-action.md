---
title: "Contratto — GetTenantConfigValueAction"
type: contract
action: "Modules\\Tenant\\Actions\\Config\\GetTenantConfigValueAction"
module: Tenant
status: accepted
created: 2026-11-25
updated: 2026-11-26
---

# GetTenantConfigValueAction

Risolve una chiave di config fondendo il gruppo base (`config('<gruppo>')`) con quello del tenant (`config('<tenant con . >.<gruppo>')`); i valori
del tenant prevalgono. Funziona uguale in web, console, coda e scheduler. `ResolveTenantConfigValueAction` è un alias stabile che delega qui
(`app/Actions/Config/ResolveTenantConfigValueAction.php`) e non ha un contratto proprio. Sorgente: `app/Actions/Config/GetTenantConfigValueAction.php`.

## Input

- `string $key`: chiave con notazione a punti; il primo segmento è il gruppo.
- `string|int|array|null $_default`: valore passato a `config()` se la chiave manca.

## Output

- `float|int|string|array|null`: valore risolto.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-CONFIG-VALUE-INV-1 | Chiave vuota o gruppo vuoto lancia `Exception` prima di leggere config o tenant. | — (non dimostrato) |
| TENANT-CONFIG-VALUE-INV-2 | Il gruppo è fuso con `<tenant>.<gruppo>` (`array_replace_recursive`) e i valori del tenant prevalgono. Se cade, un ente vede la config di un altro o quella base. | — (non dimostrato) |
| TENANT-CONFIG-VALUE-INV-3 | Un valore che non è numerico, stringa, array o `null` (bool, oggetto) lancia `Exception`. | — (non dimostrato) |
| TENANT-CONFIG-VALUE-INV-4 | Chiave assente = `$_default`, passato a `config()`. | — (non dimostrato) |
## Effetti collaterali

- `Config::set($group, $mergeConf)` sostituisce in memoria l'intero gruppo per il resto del processo: la config base di quel gruppo resta modificata anche per chi non è tenant-aware. Non scrive su disco.
- Legge la config base e quella del tenant, e il nome tenant da `GetTenantNameAction`.

## Errori

- `Exception` generica con messaggio `[riga][classe]` nei casi INV-1 e INV-3.

## Non fa

- Non crea né modifica file.
- Limite noto: un valore `null` già presente nella config non viene sostituito dal default (comportamento di `Arr::get`, `vendor/laravel/framework/src/Illuminate/Collections/Arr.php`).
- Limite noto: i messaggi delle eccezioni sono tecnici (`[riga][classe]`), non tradotti.
