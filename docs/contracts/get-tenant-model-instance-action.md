---
title: "GetTenantModelInstanceAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Models\\GetTenantModelInstanceAction"
qmd: "GetTenantModelInstanceAction istanza modello tenant risoluzione nome app Assert Model"
---

# GetTenantModelInstanceAction

Restituisce una istanza nuova del model risolto per nome. Codice: `app/Actions/Models/GetTenantModelInstanceAction.php:11-24`.

## Input

- `string $name`: come per `GetTenantModelClassAction`.

## Output

- `Model`: istanza nuova della classe risolta, creata con `app()` (righe 17-22).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `RES-MODEL-INST-INV-1` | La classe è quella di `GetTenantModelClassAction`, istanziata dal container. | righe 17-19 | `tests/Unit/Actions/Models/GetTenantModelInstanceActionTest.php` |
| `RES-MODEL-INST-INV-2` | Il risultato è un `Model`, altrimenti `Assert` lancia. | riga 20 | `tests/Unit/Actions/Models/GetTenantModelInstanceActionTest.php` |

## Effetti collaterali

Quelli di `GetTenantModelClassAction` (possibile scrittura di `morph_map`). Nessuna scrittura diretta, nessuna query.

## Errori

- Le eccezioni di `GetTenantModelClassAction` si propagano.
- `Assert::isInstanceOf` lancia se la classe non è un `Model`.

## Non fa

- Non carica record dal database.
