<<<<<<< .merge_file_RYe8cS
<<<<<<< HEAD
---
title: "Tenant Module — Documentation Index"
module: "Tenant"
type: concept
tags: [00, INDEX]
created: 2026-07-14
updated: 2026-07-14
qmd: "00 index"
related:
  - "./phpstan-corrections-january.md"
---
# Tenant Module — Documentation Index

**Path**: `laravel/Modules/Tenant/docs/`  
**Updated**: 2026-07-01  
**Status**: Multi-tenant core module

---

## 🎯 Quick Start

**Multi-tenancy 101**: [TenantIdentification.md](./wiki/tenantidentification.md) — How tenants are identified and isolated  
**Architecture**: [Architecture.md](./wiki/architecture.md) — System design and data flow  
**Configuration**: See **Multi-Tenant Config** section below ⬇️

---

## 📋 Hub Canonici (Core Files)

### Wiki (Sacred — Do Not Delete)
- **[wiki/index.md](./wiki/index.md)** — Operating manual for LLM agents
- **[wiki/Architecture.md](./wiki/architecture.md)** — Multi-tenant system design
- **[wiki/TenantIdentification.md](./wiki/tenantidentification.md)** — How tenants are identified
- **[wiki/ConfigurationDistribution.md](./wiki/configurationdistribution.md)** — Config per tenant
- **[wiki/schema.md](./wiki/schema.md)** — Database schema reference

### Roadmap
- **[roadmap/00-index.md](./roadmap/00-index.md)** — Q4 2025 roadmap and phases
- **[roadmap/vision.md](./roadmap/vision.md)** — Long-term vision
- **[roadmap/tenant-isolation.md](./roadmap/tenant-isolation.md)** — Data isolation strategy

### Product & Strategy
- **[PRD.md](./PRD.md)** — Product requirements document
- **[philosophy.md](./philosophy.md)** — Core principles
- **[README.md](./README.md)** — Module overview and local knowledge map

---

## 🏗️ Multi-Tenant Configuration

### How Tenant Config Works
=======
# 📚 **Indice Documentazione Modulo Tenant**
>>>>>>> .merge_file_2wwfK8

**Last Update**: 31 Gennaio 2026
**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 1.8.0

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Panoramica del sistema Multi-tenancy.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Dinamismo estremo e performance.
3. [philosophy.md](./philosophy.md) - "Ognuno nel suo spazio": filosofia dell'isolamento.

## 🏗️ **Architettura & Logica**
- 🏛️ **[Modular Monolith](./modular-monolith-architecture.md)** - Come il Tenant abilita la modularità.
- ⚙️ **[Configuration Logic](./configuration-logic-analysis.md)** - Risoluzione gerarchica della configurazione.
- 📂 **[Database Population](./database-population.md)** - Strategie per il seeding e la migrazione dei Tenant.

## 🛠️ **Implementazione Tecnica**
- 🧬 **[Tenant Config Path](./tenant-config-path-philosophy-debate.md)** - Filosofia della gestione dei path configurazione.
- 🐚 **[Console Integration](./resolve-tenant-config-console-debate.md)** - Risoluzione del tenant nei comandi CLI.
- 🍣 **[Sushi to JSON](./sushi-traits-phpstan-fixes.md)** - Gestione dei dati statici e semi-statici dei Tenant.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Analysis](./phpstan-level10-fixes.md)** - Report di conformità Level 10.
- 🔬 **[Testing Guidelines](./testing.md)** - Verifica dell'isolamento dei dati tra tenant.
- 🧹 **[PHPMD Fixes](./cyclomatic-complexity-report.md)** - Analisi della complessità della logica di routing.
- 🐒 **[Chaos Monkey Tenant Isolation Checklist](./chaos-monkey-tenant-isolation-checklist.md)** - Checklist operativa per fault su multi-tenant/database.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./duplicate-files-to-remove.md)** - Eliminazione dei file duplicati e obsoleti.

## 📦 **Pacchetti Composer**
- [Riferimento](../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md) - Nessuna dipendenza diretta; usa Xot
- [Package Dependency Chaos Map](./package-dependency-chaos-map.md)

## 🔗 **Moduli Correlati**
- [Xot](../../Xot/docs/README.md) - Base framework per i Service Provider.
- [User](../../User/docs/README.md) - Associazione Utente-Tenant e permessi.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

<<<<<<< .merge_file_RYe8cS
**Next Step**: Read [wiki/TenantIdentification.md](./wiki/tenantidentification.md) to understand how the current request is associated with a tenant.
=======
# 📚 **Indice Documentazione Modulo Tenant**

**Last Update**: 31 Gennaio 2026
**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 1.8.0

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Panoramica del sistema Multi-tenancy.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Dinamismo estremo e performance.
3. [philosophy.md](./philosophy.md) - "Ognuno nel suo spazio": filosofia dell'isolamento.

## 🏗️ **Architettura & Logica**
- 🏛️ **[Modular Monolith](./modular-monolith-architecture.md)** - Come il Tenant abilita la modularità.
- ⚙️ **[Configuration Logic](./configuration-logic-analysis.md)** - Risoluzione gerarchica della configurazione.
- 📂 **[Database Population](./database-population.md)** - Strategie per il seeding e la migrazione dei Tenant.

## 🛠️ **Implementazione Tecnica**
- 🧬 **[Tenant Config Path](./tenant-config-path-philosophy-debate.md)** - Filosofia della gestione dei path configurazione.
- 🐚 **[Console Integration](./resolve-tenant-config-console-debate.md)** - Risoluzione del tenant nei comandi CLI.
- 🍣 **[Sushi to JSON](./sushi-traits-phpstan-fixes.md)** - Gestione dei dati statici e semi-statici dei Tenant.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Analysis](./phpstan-level10-fixes.md)** - Report di conformità Level 10.
- 🔬 **[Testing Guidelines](./testing.md)** - Verifica dell'isolamento dei dati tra tenant.
- 🧹 **[PHPMD Fixes](./cyclomatic-complexity-report.md)** - Analisi della complessità della logica di routing.
- 🐒 **[Chaos Monkey Tenant Isolation Checklist](./chaos-monkey-tenant-isolation-checklist.md)** - Checklist operativa per fault su multi-tenant/database.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./duplicate-files-to-remove.md)** - Eliminazione dei file duplicati e obsoleti.

## 📦 **Pacchetti Composer**
- [Riferimento](../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md) - Nessuna dipendenza diretta; usa Xot
- [Package Dependency Chaos Map](./package-dependency-chaos-map.md)

## 🔗 **Moduli Correlati**
- [Xot](../../Xot/docs/README.md) - Base framework per i Service Provider.
- [User](../../User/docs/README.md) - Associazione Utente-Tenant e permessi.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
>>>>>>> 1ad0554 (.)
=======
- [Dependency intelligence](dependency-intelligence.md)
>>>>>>> .merge_file_2wwfK8
