---
id: Tenant/ecc-index
title: "ECC — indice operativo del modulo Tenant"
status: in-progress
module: Tenant
qmd: "Tenant ECC verification security testing quality gates"
references:
  - ../bmad/audit.md
  - ../../Xot/docs/ecc/00-index.md
---

# ECC — modulo Tenant

Questo indice collega le verifiche ECC applicabili al modulo e mantiene il
contratto locale PTVX: BMAD prima dell'implementazione, source-first, lock prima
degli edit, PHPStan senza baseline e Pest come gate finale.

## Verifiche obbligatorie

- Verification loop: ripetere PHPStan sul modulo dopo ogni tranche e
  registrare il risultato nella story BMAD owner.
- Laravel quality: controllare Actions Queueable, modelli Eloquent, policy,
  Filament e traduzioni secondo le convenzioni Xot.
- Security: verificare autorizzazione, tenant boundary, input non fidato,
  mass assignment, log e dati personali; nessuna conclusione senza evidenza.
- Testing: coprire i flussi critici con Pest senza closure vuote o assert
  cosmetici; non eseguire test contro l'host produttivo.
- Documentation: mantenere nomi Markdown stabili in kebab-case, frontmatter
  YAML valido, chiave qmd e indice QMD aggiornato.

## Stato delle verifiche

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato | ../bmad/audit.md |
| PHPStan modulo | pending | eseguire il comando indicato nell'audit BMAD |
| Pest modulo | pending | dipende da ambiente testing raggiungibile |
| Security review | pending | story dedicata da creare con finding reali |
| Ridondanza docs | pending | deduplicare solo dopo confronto dei contenuti |

## Regola di chiusura

Questo indice passa a status done solo quando tutti i gate hanno output
registrato, i finding aperti hanno una story o una motivazione verificata e
qmd update è stato eseguito. Un audit statico non equivale a un audit
completo.

