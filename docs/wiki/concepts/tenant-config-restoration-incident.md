---
issues: []
discussions: []
title: Ripristino config tenant dopo delete accidentale
type: troubleshooting
confidence: high
created: 2026-07-01
updated: 2026-07-01
tags: [tenant, config, incident, ponytail]
qmd: "tenant config restoration incident accidental delete GetTenantNameAction"
related:
  - ../../../../../../bashscripts/ai/wiki/concepts/modules-structure-rules.md#tenant-config-directory-sacred
  - ../../../../../../bashscripts/ai/wiki/concepts/modules-structure-rules.md#sacred-artifacts-never-delete
  - ../../../../../../docs/project/incidents/tenant-config-accidental-delete.md
  - ../../../../../../docs/project/incidents/config-directory-mismatch.md
  - ../configurationdistribution.md
  - ../../../app/Actions/GetTenantNameAction.php
---

# Ripristino config tenant — incidente 2026-07-01

## Cosa è successo

Commit `8a3fdd530` ha rimosso gli alberi config per dominio in `laravel/config/`:
`com/geekpiu`, `eu/progetto corrente`, `net/futurely`, `localhost`, file in `local/forecast/`.

Classificazione errata: «obsolete» durante cleanup ponytail.

## Perché sono necessari

`GetTenantNameAction` risolve il path `config/{tenant}/` da hostname invertito.
`GetTenantFilePathAction` e `TenantService::config()` leggono file da lì.

Senza questi file il tenant non ha override DB, moduli, metatag, contenuti Orbit.

## Ripristino

Commit `6b83dfdb2` — contenuto identico a pre-delete (`git diff 8a3fdd530^..HEAD` su `laravel/config/` = 0 righe di contenuto).

## Prevenzione

```bash
bash bashscripts/tools/guard-tenant-config-delete.sh
bash bashscripts/tools/audit-tenant-config-inventory.sh
```

Hub progetto: [modules-structure-rules.md#tenant-config-directory-sacred](../../../../../../bashscripts/ai/wiki/concepts/modules-structure-rules.md#tenant-config-directory-sacred)

## Forma canonica

Non consolidare profili diversi in un unico albero. Ogni deploy mantiene la propria cartella sotto `laravel/config/`.
