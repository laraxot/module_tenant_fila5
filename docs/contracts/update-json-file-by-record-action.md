---
title: "Contratto — UpdateJsonFileByRecordAction"
type: contract
action: "Modules\\Tenant\\Actions\\Json\\UpdateJsonFileByRecordAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# UpdateJsonFileByRecordAction

Sorgente: `app/Actions/Json/UpdateJsonFileByRecordAction.php`. Gemelle: `CreateJsonFileByRecordAction`, `DeleteJsonFileByRecordAction`.

## Input

- `Model&HasSushiToJson $record`: record con chiave valorizzata.

## Output

- `void`; il record riceve `updated_at = now()`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-JSON-UPDATE-INV-1 | La riga è identificata da `($keyName, $key)` (righe chiavizzate con `Arr::keyBy`) e sostituita; le altre restano. | — (non dimostrato) |
| TENANT-JSON-UPDATE-INV-2 | La chiave può essere intera o stringa (UUID); bool e float sono rifiutati da `Assert::validArrayKey`. | — (non dimostrato) |
| TENANT-JSON-UPDATE-INV-3 | Se la chiave non esiste nel file la riga viene aggiunta (upsert: `$keyed[$key] = ...`). | — (non dimostrato) |
| TENANT-JSON-UPDATE-INV-4 | `updated_at` vale `now()`. | — (non dimostrato) |
## Effetti collaterali

- Nell'ordine: legge le righe, imposta `updated_at` sul record, chiavizza, `EnsureKeysAction`, riscrive il file con `SaveArrayAction`. Nessuna transazione né evento.

## Errori

- `Assert::validArrayKey` lancia per chiavi non ammesse; le eccezioni di `SaveArrayAction` si propagano.

## Non fa

- Non controlla che la riga esista prima di aggiungerla (INV-3).
- Limite noto: accetta chiavi UUID, a differenza di `DeleteJsonFileByRecordAction` (solo interi o stringhe di cifre).
- Nessun chiamante in produzione (vedi `CreateJsonFileByRecordAction`).
