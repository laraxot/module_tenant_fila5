---
title: "Contratto — GetTenantModelClassAction"
type: contract
action: "Modules\\Tenant\\Actions\\Models\\GetTenantModelClassAction"
module: Tenant
status: accepted
created: 2026-11-25
updated: 2026-11-26
---

# GetTenantModelClassAction

Da un nome di model (`ticket`, `tickets`) alla classe. Usa la `morph_map` del tenant; se il nome non c'è, scansiona i moduli abilitati e
scrive la coppia nella `morph_map` del tenant. Sorgente: `app/Actions/Models/GetTenantModelClassAction.php`.

## Input

- `string $name`: nome del model, al singolare o al plurale.

## Output

- `class-string` (`string`): FQCN del model.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-MODEL-CLASS-INV-1 | Il nome è normalizzato con `Str::snake(Str::singular(...))` prima della ricerca. | — (non dimostrato) |
| TENANT-MODEL-CLASS-INV-2 | Se `morph_map.<name>` è in config, viene restituito senza scansionare i moduli. | — (non dimostrato) |
| TENANT-MODEL-CLASS-INV-3 | Se il nome non è in `morph_map`, la scansione dei moduli abilitati trova la classe e la coppia viene persistita nella `morph_map` del tenant. | — (non dimostrato) |
| TENANT-MODEL-CLASS-INV-4 | Un nome sconosciuto lancia `Exception('model unknown [...]')` e non scrive nulla. | — (non dimostrato) |
| TENANT-MODEL-CLASS-INV-5 | Un valore di `morph_map` che non è stringa lancia `Exception`. | — (non dimostrato) |
## Effetti collaterali

- Nell'ordine: legge la config (`GetTenantConfigValueAction`), eventualmente scansiona i moduli (`Module::allEnabled`, `GetAllModelsByModuleNameAction`) e scrive `config/<tenant>/morph_map.php` con `SaveTenantConfigAction`. Nessuna transazione, evento o coda.

## Errori

- `Exception('model unknown [...]')` per nomi sconosciuti (INV-4); `Exception` generica per valori non stringa (INV-5).

## Non fa

- Non istanzia il model (vedi `GetTenantModelInstanceAction`) e non verifica che la classe estenda `Model`: solo `class_exists`.
- Limite noto: se più moduli dichiarano lo stesso nome vince l'ultimo per `array_merge`, in silenzio, e quella scelta viene persistita nella config del tenant.
