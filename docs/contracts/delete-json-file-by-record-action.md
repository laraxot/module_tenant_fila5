---
title: "Contratto — DeleteJsonFileByRecordAction"
type: contract
action: "Modules\\Tenant\\Actions\\Json\\DeleteJsonFileByRecordAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# DeleteJsonFileByRecordAction

Sorgente: `app/Actions/Json/DeleteJsonFileByRecordAction.php`. Gemelle: `CreateJsonFileByRecordAction`, `UpdateJsonFileByRecordAction`.

## Input

- `Model&HasSushiToJson $record`: record con chiave.

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-JSON-DELETE-INV-1 | La chiave deve essere un intero o una stringa di sole cifre; altrimenti `Assert::true` lancia. Esclude le chiavi UUID, che l'Update accetta. | — (non dimostrato) |
| TENANT-JSON-DELETE-INV-2 | La riga con quella chiave è rimossa (`Arr::forget` sulle righe chiavizzate) e il file è riscritto come lista. | — (non dimostrato) |
| TENANT-JSON-DELETE-INV-3 | Se la chiave non esiste, il file è riscritto con le stesse righe. | — (non dimostrato) |
## Effetti collaterali

- Nell'ordine: legge le righe, `Arr::forget`, `EnsureKeysAction`, riscrive il file con `SaveArrayAction`. Non cancella nulla dal database (Sushi usa SQLite in memoria). Nessuna transazione né evento.

## Errori

- `InvalidArgumentException` da `Webmozart\Assert` per chiavi non numeriche; le eccezioni di `SaveArrayAction` si propagano.

## Non fa

- Non verifica dipendenze o relazioni con altri record.
- Nessun chiamante in produzione (vedi `CreateJsonFileByRecordAction`).
