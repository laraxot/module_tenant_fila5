---
title: "Contratto — GetDomainsArrayAction"
type: contract
action: "Modules\\Tenant\\Actions\\Domains\\GetDomainsArrayAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# GetDomainsArrayAction

Sorgente: `app/Actions/Domains/GetDomainsArrayAction.php`.

## Input

- Nessun parametro. Scansiona `config_path()`.

## Output

- `array<int, array{id: string, name: string}>`: per ogni cartella foglia, `id` e `name` sono il percorso ricostruito (`recurse` + `collapse`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-DOMAINS-INV-1 | Le cartelle chiamate `lang` sono escluse a ogni livello (`recurse`). | — (non dimostrato) |
| TENANT-DOMAINS-INV-2 | Solo le cartelle foglia (senza sottocartelle) producono un dominio (`collapse`: `$v0 === []`). | — (non dimostrato) |
| TENANT-DOMAINS-INV-3 | Il nome unisce i segmenti con `.` partendo dal più profondo (`a/b/c` dà `c.b.a`). | — (non dimostrato) |
## Effetti collaterali

- Solo lettura del filesystem. Nessuna scrittura, evento o cache.

## Errori

- Nessuna gestione esplicita: gli errori del filesystem si propagano.

## Non fa

- Non legge il contenuto dei file di configurazione e non restituisce le cartelle intermedie.
- Non verifica che il tenant abbia una riga nel database.
