---
title: "ECC — indice operativo Tenant"
type: index
status: in-progress
updated: 2026-11-16
module: Tenant
qmd: "ECC indice Tenant verification gates"
---

# ECC — modulo Tenant

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato | ../bmad/audits/tenant-audit.md |
| PHPStan | 0 su tree Modules (2026-11-16) | comando in audit |
| Pest | pending | ambiente testing |
| Security review | pending | story figlie P0/P1 |
| Docs pack | aggiornato | questo indice + audit ECC |

Dettaglio: [tenant-ecc-audit.md](./tenant-ecc-audit.md)
