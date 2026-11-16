---
title: "ECC audit operativo — Tenant"
type: ecc-audit
status: review
updated: 2026-11-16
module: Tenant
qmd: "ECC audit Tenant verification security testing laravel"
---

# ECC audit operativo — Tenant

## Contratto PTVX

ECC non sostituisce AGENTS.md/BMAD. Ogni finding: story BMAD, lock, fix causa,
PHPStan + Pest, aggiornamento docs/QMD.

## Checklist

- [ ] `clean-code`: DRY/KISS, Actions su Services, niente wrapper inutili
- [ ] `security-review`: policy, mass assignment, export, log, privacy, tenant
- [ ] `laravel-verification`: route, config, migration additive, container
- [ ] `verification-loop`: PHPStan level max + Pest mirato
- [ ] `tdd-workflow`: regressione sui finding P0
- [ ] `documentation-sync`: story + indici + qmd
- [ ] `context-engineering`: QMD/graphify prima; registrare il perché dopo

## Input misurato (2026-11-16)

| Voce | N |
|---|---:|
| app PHP | 56 |
| test | 65 |
| resources | 1 |
| actions | 19 |
| services | 0 |
| policies (files approx) | 4 |

## Gate osservati

- PHPStan `Modules` (2026-11-16): 0 errori
- Pest: pending (ambiente testing)

## Anti-pattern vietati

- baseline/`@phpstan-ignore` senza motivazione
- test svuotati per silenziare errori
- migrate:fresh / RefreshDatabase / --force
- docs con date nel nome file
- comportamento o screenshot inventati

## Riferimenti

- [00-index](./00-index.md)
- [BMAD audit](../bmad/audit.md)
