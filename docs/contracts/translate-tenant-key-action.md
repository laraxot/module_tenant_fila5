---
title: "Contratto — TranslateTenantKeyAction"
type: contract
action: "Modules\\Tenant\\Actions\\Translations\\TranslateTenantKeyAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# TranslateTenantKeyAction

Sorgente: `app/Actions/Translations/TranslateTenantKeyAction.php`.

## Input

- `string $key`: il primo segmento (prima del punto) è il nome del file in `lang/<locale>/`; il resto è la chiave annidata.

## Output

- `string`: la traduzione, oppure la chiave originale se non si risolve.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-TRANS-INV-1 | Se il file di lingua del tenant non esiste si restituisce la chiave. | — (non dimostrato) |
| TENANT-TRANS-INV-2 | Se il valore trovato non è una stringa si restituisce la chiave. | — (non dimostrato) |
| TENANT-TRANS-INV-3 | Se il file esiste ma non restituisce un array, `Assert::isArray` lancia. | — (non dimostrato) |
## Effetti collaterali

- Esegue il file di lingua con `File::getRequire`. Nessuna scrittura.

## Errori

- `InvalidArgumentException` da `Assert::isArray` (INV-3); `InvalidArgumentException` da `GetTenantFilePathAction` per nomi con traversal.

## Non fa

- Non usa la lingua di default dell'app come ripiego.
- Limite noto: una chiave senza punto usa la chiave intera sia come nome del file sia come chiave annidata (`Str::before`/`Str::after` restituiscono la stringa intera).
