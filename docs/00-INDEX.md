---
issues: []
discussions: []
title: "Tenant Module — Documentation Index"
module: "Tenant"
type: concept
tags: [00, INDEX]
created: 2026-07-14
updated: 2026-10-20
qmd: "tenant module docs index canonico host config directory evidence legacy"
status: active
related:
  - "./phpstan-corrections-january.md"
---
# Tenant Module — Documentation Index

**Path**: `laravel/Modules/Tenant/docs/`  
**Updated**: 2026-10-14  
**Status**: Multi-tenant core module

---

## 🎯 Quick Start

**Come funziona davvero (verificato 2026-10-14)**: [README.md](./README.md). Il tenant e' la cartella `laravel/config/<host invertito>/` scelta da `GetTenantNameAction` (`fixcity.local` diventa `local/fixcity`); non c'e' isolamento per riga ne' `TenantService`.  
**Comando di prova**: `cd laravel && php artisan tenant:test` (stampa `tenant name :local/fixcity`).  
**Pagine wiki Architecture, TenantIdentification, ConfigurationDistribution**: marcate `stale` il 2026-10-14 (descrivono un TenantService e sottodomini che non esistono).

---

## 📋 Hub Canonici (Core Files)

### Wiki (Sacred — Do Not Delete)
- **[wiki/index.md](./wiki/index.md)** — Operating manual for LLM agents
- **[wiki/Architecture.md](./wiki/architecture.md)** — Multi-tenant system design (stale, vedi README.md)
- **[wiki/TenantIdentification.md](./wiki/tenantidentification.md)** — How tenants are identified (stale, vedi README.md)
- **[wiki/ConfigurationDistribution.md](./wiki/configurationdistribution.md)** — Config per tenant (stale, vedi README.md)
---
- **[wiki/Architecture.md](./wiki/Architecture.md)** — Multi-tenant system design
- **[wiki/TenantIdentification.md](./wiki/TenantIdentification.md)** — How tenants are identified
- **[wiki/ConfigurationDistribution.md](./wiki/ConfigurationDistribution.md)** — Config per tenant
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

This project uses **environment-specific tenant configuration**:

```
laravel/config/
├── localhost/              # tenant di ripiego, 23 file di config come gli altri
├── local/fixcity/          # tenant di sviluppo, host fixcity.local
├── eu/fixcity/             # tenant EU
└── net/futurely/           # tenant Futurely
```
(Elenco verificato con `ls` il 2026-10-14. `com/geekpiu` non esiste piu'.)

**Each tenant context includes**:
- `app.php` — Locale, timezone, app name per tenant
- `database.php` — Separate DB connection per tenant
- `services.php` — API credentials per tenant
- `modules.php` — Active modules per tenant
- `modules_statuses.json` — Module status overrides
- `morph_map.php` — Model registry (CRITICAL — never delete)

### Why This Architecture

1. **Data Isolation** — Each tenant has own database or schema
2. **Environment Separation** — Different APIs/credentials per deployment
3. **Module Availability** — Different features per tenant
4. **Local Development** — `localhost/` provides isolated dev environment

### Related Memory Files

For deep understanding of multi-tenant configuration:
- **[config-architecture-multi-tenant](../../../../.claude/config_architecture_documentation.md)** _(target mancante, verificato 2026-10-14)_ — Detailed architecture guide
- **[error_config_deletion_2026_07_01](../../../../.claude/error_config_deletion_2026_07_01.md)** _(target mancante, verificato 2026-10-14)_ — Critical lessons learned

> **CRITICAL RULE**: Never delete files under `laravel/config/`. These are KNOWN tenant configurations, not speculative code. Always grep before deleting any config file.

---

## 🧠 Core Concepts

**Tenant Scoping**: NON implementato. Nessun global scope ne' `BelongsToTenant` nel modulo (grep 2026-10-14).  
**Tenant Resolution**: da `SERVER_NAME` o host di `APP_URL`, inverso delle parti, prima cartella esistente in `config/` (`Actions/GetTenantNameAction.php`).  
**Data Boundaries**: non dimostrati. Le tabelle `tenant_settings`, `tenant_subscriptions`, `database_configs` hanno `tenant_id` come stringa nullable, senza chiave esterna.  
**Config Hierarchy**: `ResolveTenantConfigValueAction` fonde `config/<gruppo>.php` con `config/<tenant>/<gruppo>.php`.

---

## 🛠️ Development Rules

| Rule | Source |
|------|--------|
| No Services — use Actions | [wiki/concepts/](./wiki/concepts/) |
| Tenant scoping automatic | non implementato (vedi sopra) |
| Config per tenant required | [README.md](./README.md), `ResolveTenantConfigValueAction` |
| No hardcoded credentials | Via `laravel/config/{tenant}/` |
| Modelli Sushi: `unique`/`exists` richiedono la connessione per nome | [stories/7.4.sushi-connection-by-name.story.md](./stories/7.4.sushi-connection-by-name.story.md), [bmad/sushi-model-pitfalls.md](./bmad/sushi-model-pitfalls.md) |

---

## Mappa delle directory di docs/ (2026-10-14)

| Directory | Ruolo | File .md |
|---|---|---|
| `README.md`, `wiki/` | canonici (README verificato sul codice; le tre pagine wiki citate sopra sono stale) | 74 in wiki |
| `stories/` | evidence BMAD | 22 |
| `bmad/` | evidence (brainstorming, architecture, quick-reference, story storiche) | 76 |
| `roadmap/` | piani, non stato | 41 |
| `investigation/`, `bugfix/` | diagnosi | 1 e 2 |
| `traits/`, `models/`, `concepts/` | riferimenti tecnici sui trait Sushi e i modelli | 11, 2, 2 |
| `it/`, `en/` | legacy (about, tutorial) | 31, 4 |
| `_integration/`, `html2pdf/`, `analysis/`, `architecture/`, `development/`, `tasks/`, `prompts/`, `outputs/`, `llm-wiki/` | legacy o evidence di sessioni passate | 7, 6, 1, 1, 1, 1, 1, 1, 7 |
| `raw/` | sorgenti immutabili | 23 |

Il contratto (`bmad-output/docs-architecture/module-theme-docs-contract.md`) vuole `00-INDEX.md` come indice operativo: in Tenant lo e'. `index.md` e `00-index.md` sono varianti storiche, non crearne altre.

## 📁 Archive & Legacy

**Note**: This module has ~360 documentation files accumulated over years. Only the canonical files above (wiki/, roadmap/, PRD, README) are actively maintained. Other files are:
- **Legacy**: Historical decisions no longer active
- **Duplicates**: Multiple versions of same content (ponytail cleanup deferred)
- **Task-specific**: Archived from past sprints

**Rule**: When documenting Tenant module features:
1. Update [wiki/](./wiki/) first (canonical source)
2. Link from 00-index.md (this file)
3. Archive old duplicates if found

---

## 🔗 Related Modules

- **[User Module](../../User/docs/00-index.md)** — Authentication per tenant
- **[Xot Module](../../Xot/docs/00-INDEX.md)** — Base classes for tenant awareness
- **[Theme System](../../../Themes/)** — Theme per tenant support

---

**Next Step**: Read [wiki/TenantIdentification.md](./wiki/tenantidentification.md) to understand how the current request is associated with a tenant.

## Documentazione BMAD del modulo

Aggiornata il 2026-10-07 dopo la risoluzione dei marker di merge nei docs (versioni composte, non scelte a un lato).

- [Brainstorming](bmad/brainstorming.md): decisioni, questioni aperte, opzioni scartate.
- [Architecture](bmad/architecture.md)
- [Quick reference](bmad/quick-reference.md)
- [Setup guide](bmad/setup-guide.md)
- Story: cartella [bmad/stories/](bmad/stories/).
- Story Services 2026-10-08: [TenantService e Services/Config eliminati](stories/services-to-actions-tenant.story.md). **Superata dai fatti il 2026-10-20**: il pull ha riportato `app/Services/` (vedi la story qui sotto e [services-config-dead-code-retired.md](services-config-dead-code-retired.md)).
- Story parita' 2026-10-20 (epic Service verso QueueableAction, W2): [TenantService e Services/Config contro le Action successore](stories/services-parity-audit-tenant.story.md), con i difetti ereditati sul boot path.
- Story PHPStan 2026-10-20: [regressione dei test dopo il pull](stories/phpstan-test-wave-tenant.story.md) (TestCase e test riportati alla generazione tipizzata, `app/Services` corretto sul posto).
- La story `phpstan-tenant-sushi-benchmark-category.story.md`, linkata qui fino al 2026-10-14, non esiste piu' nel modulo: link rimosso.
