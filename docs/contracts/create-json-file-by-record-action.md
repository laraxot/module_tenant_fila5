---
title: "Contratto — CreateJsonFileByRecordAction"
type: contract
action: "Modules\\Tenant\\Actions\\Json\\CreateJsonFileByRecordAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# CreateJsonFileByRecordAction

Sorgente: `app/Actions/Json/CreateJsonFileByRecordAction.php`. Gemelle: `UpdateJsonFileByRecordAction`, `DeleteJsonFileByRecordAction`.

## Input

- `Model&HasSushiToJson $record`: il record da aggiungere, non ancora salvato.

## Output

- `void`; il record riceve `id`, `created_at`, `updated_at`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-JSON-CREATE-INV-1 | Nuovo id = max(id numerici esistenti) + 1; gli id stringa numerici (`"11"`) valgono come interi (`SafeIntCastAction`). Se cade, due record condividono l'id. | `TENANT-JSON-CREATE-INV-1` |
| TENANT-JSON-CREATE-INV-2 | File senza righe = id 1, nessuna `ValueError` da `max()` (il `0` iniziale in `max([0, ...$ids])`). | `TENANT-JSON-CREATE-INV-2` |
| TENANT-JSON-CREATE-INV-3 | Ogni riga scritta ha tutte le chiavi di `getSchema()` (`EnsureKeysAction`) e le righe esistenti restano. | — (non dimostrato) |
## Effetti collaterali

- Imposta `created_at`/`updated_at` sul record, poi riscrive per intero `$record->getJsonFile()` con `SaveArrayAction` (JSON del tenant, o la copia di test: vedi `GetTenantFilePathAction`).

## Errori

- Errori di scrittura del filesystem si propagano.

## Non fa

- Limite noto: non è chiamata dal trait `SushiToJson`, che ha i propri handler `creating`/`updating`/`deleting` in `bootSushiToJson()` con un calcolo dell'id simile ma non identico. Le tre Action Json non hanno chiamanti in produzione (`rg` su `Modules`/`Themes` fuori da tests e docs, 2026-11-26): prima di usarle o toglierle, allineare il trait.
- Non gestisce scritture concorrenti né lock del file.
