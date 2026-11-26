---
title: "Contratto — FilterConfigStringKeysAction"
type: contract
action: "Modules\\Tenant\\Actions\\Config\\FilterConfigStringKeysAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# FilterConfigStringKeysAction

Sorgente: `app/Actions/Config/FilterConfigStringKeysAction.php`.

## Input

- `array<mixed, mixed> $config`: array con chiavi di qualunque tipo.

## Output

- `array<string, mixed>`: le stesse voci con chiave stringa, nello stesso ordine.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-FILTER-INV-1 | Il risultato contiene solo chiavi stringa; le chiavi intere sono scartate. | — (non dimostrato) |
| TENANT-FILTER-INV-2 | Il filtro è solo di primo livello: le chiavi intere annidate restano (nessuna ricorsione). | — (non dimostrato) |
| TENANT-FILTER-INV-3 | L'input non viene modificato (il risultato è una variabile locale). | — (non dimostrato) |
## Effetti collaterali

- Nessuno: calcolo puro.

## Errori

- Nessuna eccezione.

## Non fa

- Non ricorre nei sottoarray, non riordina e non valida i valori.
