---
title: "Contratto — GetTenantConfigPathAction"
type: contract
action: "Modules\\Tenant\\Actions\\Config\\GetTenantConfigPathAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# GetTenantConfigPathAction

Sorgente: `app/Actions/Config/GetTenantConfigPathAction.php`.

## Input

- `string $key`: chiave relativa, ad esempio `app.name`.

## Output

- `string`: `<tenant con '.' al posto di '/'>.<key>`. Tenant `local/ptvx` e chiave `app.name` danno `local.ptvx.app.name`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-CFG-PATH-INV-1 | Ogni `/` del nome tenant diventa `.`. | `TENANT-CFG-PATH-INV-1` |
| TENANT-CFG-PATH-INV-2 | `$key` non viene validato né normalizzato. | — (non dimostrato) |
## Effetti collaterali

- Nessuno: legge solo il nome tenant da `GetTenantNameAction`.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non verifica che la chiave esista in `config()` e non legge né scrive file.
