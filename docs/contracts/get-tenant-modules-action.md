---
title: "Contratto — GetTenantModulesAction"
type: contract
action: "Modules\\Tenant\\Actions\\Modules\\GetTenantModulesAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# GetTenantModulesAction

Sorgente: `app/Actions/Modules/GetTenantModulesAction.php`.

## Input

- Nessun parametro. Legge `modules_statuses.json` del tenant tramite `GetTenantFilePathAction`.

## Output

- `array<int, string>`: nomi dei moduli con valore `true` nel file e con cartella `Modules/<nome>` presente.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-MODULES-INV-1 | Un modulo è incluso solo se il suo valore è vero e la cartella `Modules/<nome>` esiste (`collectEnabledModules`). | — (non dimostrato) |
| TENANT-MODULES-INV-2 | Se il JSON non è un array il risultato è `[]`. | — (non dimostrato) |
## Effetti collaterali

- Solo lettura del file e del filesystem. Nessuna scrittura.

## Errori

- File mancante: `File::get` lancia, fuori dal `try`, e l'eccezione si propaga.
- JSON non valido: `Safe\json_decode` lancia e il `catch` la rilancia come `Exception` con messaggio, percorso del file e riga.

## Non fa

- Non verifica che il modulo sia registrato in nwidart.
