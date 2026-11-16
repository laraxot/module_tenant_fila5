---
title: "Audit BMAD — Tenant"
type: audit
status: review
updated: 2026-11-16
module: Tenant
qmd: "audit BMAD Tenant source-first qualità"
---

# Audit BMAD — Tenant

SSoT dettagliata: [audits/tenant-audit.md](./audits/tenant-audit.md)

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` | 56 |
| Test | 65 |
| Resources | 1 |
| Actions | 19 |
| Services | 0 |
| Policy `return true` | 2 |
| Marker | 0 |

## Lo scopo in una frase **Tenant permette a una sola installazione di servire piu' enti senza che nessuno veda i dati dell'altro, e di farlo cambiando configurazione invece che codice.**

## Gate

- PHPStan modulo / `Modules`: 0 errori (verifica 2026-11-16).
- Pest: da eseguire in ambiente testing non produttivo.
- Security/runtime: story figlie su finding P0/P1 dell'audit dettagliato.
