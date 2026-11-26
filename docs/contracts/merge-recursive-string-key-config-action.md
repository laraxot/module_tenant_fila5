---
title: "Contratto — MergeRecursiveStringKeyConfigAction"
type: contract
action: "Modules\\Tenant\\Actions\\Config\\MergeRecursiveStringKeyConfigAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# MergeRecursiveStringKeyConfigAction

Sorgente: `app/Actions/Config/MergeRecursiveStringKeyConfigAction.php`.

## Input

- `array<array-key, mixed> ...$configs`: uno o più array, anche con chiavi intere.

## Output

- `array<string, mixed>`: fusione ricorsiva; con zero argomenti `[]`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-MERGE-INV-1 | Il risultato ha solo chiavi stringa di primo livello (ogni input e il risultato passano da `FilterConfigStringKeysAction`). | — (non dimostrato) |
| TENANT-MERGE-INV-2 | Con più array vince l'ultimo per ogni chiave foglia (`array_replace_recursive`). | — (non dimostrato) |
## Effetti collaterali

- Nessuno: calcolo puro.

## Errori

- Nessuna eccezione propria.

## Non fa

- Il filtro non è ricorsivo: le chiavi intere dentro i sottoarray restano.
