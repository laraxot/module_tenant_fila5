---
title: "Contratto — GetLocalizedMarkdownPathAction"
type: contract
action: "Modules\\Tenant\\Actions\\Markdown\\GetLocalizedMarkdownPathAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# GetLocalizedMarkdownPathAction

Sorgente: `app/Actions/Markdown/GetLocalizedMarkdownPathAction.php`.

## Input

- `string $name`: percorso relativo del markdown (ad esempio `privacy.md`).

## Output

- `string`: percorso assoluto del primo file esistente, nell'ordine `lang/<locale>/<name>` poi `<name>`; `'#'` se nessuno esiste.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-MD-INV-1 | Vince la versione nella lingua corrente, se esiste. | — (non dimostrato) |
| TENANT-MD-INV-2 | Se esiste solo il file senza prefisso lingua, vale quello. | — (non dimostrato) |
| TENANT-MD-INV-3 | Se nessun file esiste il risultato è `'#'`. | — (non dimostrato) |
| TENANT-MD-INV-4 | Ogni percorso passa da `GetTenantFilePathAction`: un nome con traversal lancia `InvalidArgumentException`. | — (non dimostrato) |
## Effetti collaterali

- Solo `file_exists`. Nessuna scrittura.

## Errori

- `InvalidArgumentException` da `GetTenantFilePathAction`: propagata.

## Non fa

- Non legge il contenuto e non ripiega sulla lingua di default dell'app: il ripiego è solo il file senza prefisso lingua.
