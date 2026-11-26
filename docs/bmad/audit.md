---
title: "Audit BMAD — Tenant"
type: audit
status: review
updated: 2026-11-16
module: Tenant
<<<<<<< .merge_file_zXDBcS
<<<<<<< .merge_file_TgzQy3
qmd: "audit BMAD Tenant source-first qualità"
=======
qmd: "audit BMAD Tenant sintesi Host header TrustHosts tenant admin bypass DatabaseConfig password PHPStan Pest skip"
>>>>>>> .merge_file_YofoKB
=======
qmd: "audit BMAD Tenant sintesi source-first qualità Host header TrustHosts tenant admin bypass DatabaseConfig password PHPStan Pest skip"
>>>>>>> .merge_file_CVwlSI
---

# Audit BMAD — Tenant

<<<<<<< .merge_file_zXDBcS
<<<<<<< .merge_file_TgzQy3
SSoT dettagliata: [audits/tenant-audit.md](./audits/tenant-audit.md)
=======
SSoT dettagliata: [audits/tenant-audit.md](./audits/tenant-audit.md). Questo file è solo la sintesi.
>>>>>>> .merge_file_YofoKB
=======
SSoT dettagliata: [audits/tenant-audit.md](./audits/tenant-audit.md). Questo file è solo la sintesi.
>>>>>>> .merge_file_CVwlSI

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` | 56 |
<<<<<<< .merge_file_zXDBcS
<<<<<<< .merge_file_TgzQy3
| Test | 65 |
| Resources | 1 |
| Actions | 19 |
| Services | 0 |
=======
| Test (file PHP / `*Test.php`) | 65 / 45 |
| Models top-level | 10 |
| Resource / Actions / Services / Policy | 1 / 19 / 0 / 2 |
| Migration | 3 |
| Marker conflitto | 0 |
| P0 / P1 / P2 | 0 / 3 / 9 |
>>>>>>> .merge_file_CVwlSI
| Policy `return true` | 2 |

## Lo scopo in una frase

**Tenant permette a una sola installazione di servire più enti senza che nessuno veda i dati dell'altro, e di farlo cambiando configurazione invece che codice.**

## Top finding

1. **TEN-P1-01** — tenant scelto da `SERVER_NAME`/`Host` con `TrustHosts` non attivo ([GetTenantNameAction.php:114-148](../../app/Actions/GetTenantNameAction.php)).
2. **TEN-P1-02** — `tenant::admin` aggira ogni policy, delete compresi ([TenantBasePolicy.php:14-22](../../app/Models/Policies/TenantBasePolicy.php)).
3. **TEN-P1-03** — `DatabaseConfig.password` in chiaro, senza cast `encrypted` né `$hidden`.

## Gate

<<<<<<< .merge_file_zXDBcS
- PHPStan modulo / `Modules`: 0 errori (verifica 2026-11-16).
- Pest: da eseguire in ambiente testing non produttivo.
- Security/runtime: story figlie su finding P0/P1 dell'audit dettagliato.
=======
| Test (file PHP / `*Test.php`) | 65 / 45 |
| Models top-level | 10 |
| Resource / Actions / Services / Policy | 1 / 19 / 0 / 2 |
| Migration | 3 |
| Marker conflitto | 0 |
| P0 / P1 / P2 | 0 / 3 / 8 |

## Top finding

1. **TEN-P1-01** — tenant scelto da `SERVER_NAME`/`Host` con `TrustHosts` non attivo ([GetTenantNameAction.php:114-148](../../app/Actions/GetTenantNameAction.php)).
2. **TEN-P1-02** — `tenant::admin` aggira ogni policy, delete compresi ([TenantBasePolicy.php:14-22](../../app/Models/Policies/TenantBasePolicy.php)).
3. **TEN-P1-03** — `DatabaseConfig.password` in chiaro, senza cast `encrypted` né `$hidden`.

## Gate

- PHPStan `Modules/Tenant`: **0 errori** (level max, 2026-11-16).
- Pest: **skip documentato** (bootstrap bloccato, DB test `10.100.200.53` non raggiungibile).
=======
- PHPStan `Modules/Tenant`: **0 errori** (level max, 2026-11-16).
- Pest: **skip documentato** (bootstrap bloccato, DB test `10.100.200.53` non raggiungibile); da eseguire in ambiente testing non produttivo.
- Security/runtime: story figlie sui finding P1 dell'audit dettagliato.
>>>>>>> .merge_file_CVwlSI

## Riferimenti

[ECC](../ecc/tenant-ecc-audit.md) · [epics](./epics.md) · [story](./stories/module-bmad-audit.story.md)
<<<<<<< .merge_file_zXDBcS
>>>>>>> .merge_file_YofoKB
=======
>>>>>>> .merge_file_CVwlSI
