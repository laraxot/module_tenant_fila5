---
title: "Contratto — GetTenantFilePathAction"
type: contract
action: "Modules\\Tenant\\Actions\\Config\\GetTenantFilePathAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# GetTenantFilePathAction

Unico punto che trasforma un nome relativo in `config/<tenant>/<nome>`: tutte le Action Json/Config del modulo passano da qui,
quindi è la difesa da path traversal. Perché: [ADR 0003](../adr/0003-tenant-name-from-reversed-host.md), [ADR 0002](../adr/0002-tenant-json-content-isolated-in-tests.md).
Sorgente: `app/Actions/Config/GetTenantFilePathAction.php`.

## Input

- `string $filename`: percorso relativo alla cartella del tenant (`database.php`, `database/content/pages.json`).

## Output

- `string`: percorso assoluto con i separatori del sistema operativo.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-FILE-PATH-INV-1 | Fuori dai test il percorso è `base_path('config/<tenant>/<filename>')`, tenant da `GetTenantNameAction`. | `TENANT-FILE-PATH-INV-1` |
| TENANT-FILE-PATH-INV-2 | Percorso assoluto, segmento `..` (anche con `\`) o byte NUL = `InvalidArgumentException`, prima di leggere il tenant. Se cade, un nome costruito dall'utente esce da `config/<tenant>/`. | `TENANT-FILE-PATH-INV-2` |
| TENANT-FILE-PATH-INV-3 | Con `runningUnitTests()` un nome sotto `database/content/` punta a `storage/framework/testing/tenant-content/<tenant>/...`, mai a `config/`. Se cade, i test scrivono nei JSON CMS versionati. | `TENANT-FILE-PATH-INV-3` |
## Effetti collaterali

- Solo nei test e solo per `database/content/`: la prima volta per processo `prepareTestingContent` cancella e ricopia
  `storage/framework/testing/tenant-content/<tenant>/database/content` dai JSON versionati; poi copia il file o la cartella richiesta se manca.
- Fuori dai test: nessuno (calcolo di stringa).

## Errori

- `InvalidArgumentException('Tenant filename must be a relative path without traversal segments.')`.

## Non fa

- Non controlla che il file esista e non lo crea (fuori dalla copia di test).
- Non normalizza i symlink e non valida il nome tenant: lo riceve da `GetTenantNameAction`.
