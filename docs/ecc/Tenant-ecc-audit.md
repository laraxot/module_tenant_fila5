---
id: Tenant/ecc-audit
title: "ECC — audit di qualità del modulo Tenant"
status: in-progress
module: Tenant
qmd: "Tenant ECC audit verification security testing"
references:
  - ../bmad/audit.md
  - 00-index.md
---

# ECC — audit Tenant

## Checklist source-first

- [ ] PHPStan level massimo sul modulo, senza baseline o ignoreErrors.
- [ ] Pest eseguito in ambiente testing sicuro e risultato registrato.
- [ ] PHP lint e diff check sui file modificati.
- [ ] Autorizzazione, tenant boundary e mass assignment verificati.
- [ ] Actions, modelli, policy, Filament e traduzioni confrontati con Xot.
- [ ] Duplicazioni e documenti storici classificati prima di qualsiasi rimozione.
- [ ] QMD e graphify aggiornati dopo la modifica documentale.

## Registro dei finding

Nessun finding semantico viene inventato in questo documento. Ogni finding deve
riportare file, comportamento atteso, causa radice, rischio, fix minimo, test e
story BMAD collegata. I conteggi statici iniziali e i gate pending sono in
docs/bmad/audit.md.

## Criterio di chiusura

Lo stato passa a done solo dopo la compilazione completa della checklist e la
registrazione degli output dei gate. Un audit statico non equivale a un audit
completo.

