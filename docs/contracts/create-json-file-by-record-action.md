---
title: "Contratto — CreateJsonFileByRecordAction"
type: contract
<<<<<<< .merge_file_qbfWkz
action: "Modules\Tenant\Actions\Json\CreateJsonFileByRecordAction"
tags: [contract, action, tenant, sushi, json]
created: 2026-11-24
updated: 2026-11-24
=======
action: "Modules\\Tenant\\Actions\\Json\\CreateJsonFileByRecordAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
>>>>>>> .merge_file_OhCUdR
---

# CreateJsonFileByRecordAction

<<<<<<< .merge_file_qbfWkz
Sorgente: `app/Actions/Json/CreateJsonFileByRecordAction.php`. Gemelle: `UpdateJsonFileByRecordAction`,
`DeleteJsonFileByRecordAction` (stessa chiave `($keyName, $key)`).
=======
Sorgente: `app/Actions/Json/CreateJsonFileByRecordAction.php`. Gemelle: `UpdateJsonFileByRecordAction`, `DeleteJsonFileByRecordAction`.
>>>>>>> .merge_file_OhCUdR

## Input

- `Model&HasSushiToJson $record`: il record da aggiungere, non ancora salvato.

## Output

- `void`; il record riceve `id`, `created_at`, `updated_at`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
<<<<<<< .merge_file_qbfWkz
| TENANT-JSON-CREATE-INV-1 | Nuovo id = max(id numerici esistenti) + 1; gli id stringa numerici (`"11"`) valgono come interi, quelli non numerici come 0. | `TENANT-JSON-CREATE-INV-1` |
| TENANT-JSON-CREATE-INV-2 | File senza righe = id 1, nessuna `ValueError` da `max()`. | `TENANT-JSON-CREATE-INV-2` |
| TENANT-JSON-CREATE-INV-3 | Ogni riga scritta ha tutte le chiavi di `getSchema()` (`EnsureKeysAction`), le righe esistenti restano. | — |

## Effetti collaterali

- Riscrive per intero `$record->getJsonFile()` (JSON del tenant, o la copia di test: vedi `GetTenantFilePathAction`).
=======
| TENANT-JSON-CREATE-INV-1 | Nuovo id = max(id numerici esistenti) + 1; gli id stringa numerici (`"11"`) valgono come interi (`SafeIntCastAction`). Se cade, due record condividono l'id. | `TENANT-JSON-CREATE-INV-1` |
| TENANT-JSON-CREATE-INV-2 | File senza righe = id 1, nessuna `ValueError` da `max()` (il `0` iniziale in `max([0, ...$ids])`). | `TENANT-JSON-CREATE-INV-2` |
| TENANT-JSON-CREATE-INV-3 | Ogni riga scritta ha tutte le chiavi di `getSchema()` (`EnsureKeysAction`) e le righe esistenti restano. | — (non dimostrato) |
## Effetti collaterali

- Imposta `created_at`/`updated_at` sul record, poi riscrive per intero `$record->getJsonFile()` con `SaveArrayAction` (JSON del tenant, o la copia di test: vedi `GetTenantFilePathAction`).
>>>>>>> .merge_file_OhCUdR

## Errori

- Errori di scrittura del filesystem si propagano.

## Non fa

<<<<<<< .merge_file_qbfWkz
- **Non è chiamata dal trait `SushiToJson`**: il trait ha i propri handler `creating`/`updating`/`deleting` in
  `bootSushiToJson()`, con un calcolo dell'id simile ma non identico (considera anche il max della tabella in memoria).
  Oggi le tre Action Json non hanno chiamanti in produzione: prima di usarle o toglierle, allineare il trait.
=======
- Limite noto: non è chiamata dal trait `SushiToJson`, che ha i propri handler `creating`/`updating`/`deleting` in `bootSushiToJson()` con un calcolo dell'id simile ma non identico. Le tre Action Json non hanno chiamanti in produzione (`rg` su `Modules`/`Themes` fuori da tests e docs, 2026-11-26): prima di usarle o toglierle, allineare il trait.
>>>>>>> .merge_file_OhCUdR
- Non gestisce scritture concorrenti né lock del file.
