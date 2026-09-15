---
id: module-tenant-readme
title: "Tenant — Multi-tenancy e Isolamento Organizzativo"
type: module-readme
category: module-documentation
module: Tenant
status: active
tags: [tenant, multitenancy, isolation, organization]
created: 2026-09-14
updated: 2026-09-14
qmd: "tenant multitenancy isolation domains configuration module documentation"
issues:
  - "https://github.com/laraxot/module_tenant_fila5/issues/46"
discussions:
  - "https://github.com/laraxot/module_tenant_fila5/discussions/47"
related:
  - "./docs/"
sources: []
---

# 🏢 Tenant

> **Multi-tenancy e isolamento organizzativo.**

Tenant, domini, configurazione e appartenenza degli utenti.

## Cosa offre

- **Identificazione** – tenancy ID e ruoli
- **Config organizzativa** – impostazioni per entità
- **Utenti/tenant** – membership e permessi
- **Isolamento dati**

## Confini architetturali

This module publishes contracts usable by other modules. Logic lives in `Actions`; admin UI follows Laraxot/XotBase.

## Integrazione rapida

```bash
cd laravel
php artisan module:list
./vendor/bin/phpstan analyse Modules/Tenant
```

See local docs for integration patterns.

## Documentazione

The technical map is in [docs/README.md](./docs/README.md).

- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto../../../docs/wiki/
- [README del progetto../../README.md]

## Qualità e manutenzione

Keep `declare(strict_types=1);` in PHP, respect project PHPStan config, and update docs when contracts evolve.

---

**Modulo** `tenant` · **Laraxot ecosystem** · **Project-agnostic**
