---
title: "Contratto — GetTenantModelInstanceAction"
type: contract
action: "Modules\\Tenant\\Actions\\Models\\GetTenantModelInstanceAction"
module: Tenant
status: accepted
created: 2026-11-25
updated: 2026-11-26
---

# GetTenantModelInstanceAction

Sorgente: `app/Actions/Models/GetTenantModelInstanceAction.php`.

## Input

- `string $name`: come per `GetTenantModelClassAction`.

## Output

- `Model`: istanza nuova, creata con `app()`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-MODEL-INST-INV-1 | La classe è quella di `GetTenantModelClassAction`, istanziata dal container. | — (non dimostrato) |
| TENANT-MODEL-INST-INV-2 | Il risultato è un `Model`, altrimenti `Assert::isInstanceOf` lancia. | — (non dimostrato) |
## Effetti collaterali

- Quelli di `GetTenantModelClassAction` (possibile scrittura della `morph_map`). Nessuna scrittura diretta, nessuna query.

## Errori

- Le eccezioni di `GetTenantModelClassAction` si propagano; `Assert::isInstanceOf` lancia se la classe non è un `Model`.

## Non fa

- Non carica record dal database.
