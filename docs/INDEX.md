---
<<<<<<< .merge_file_hpYlZi
title: "INDEX"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "INDEX"
issues: []
discussions: []
---

# Documentation Index

Modulo: Tenant

## File disponibili

<!-- auto-generato: elencare i file .md presenti -->
---
title: "INDEX"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "INDEX"
issues: []
discussions: []
---
title: Tenant Module Documentation Index
module: Tenant
status: production
last_updated: 2026-07-28
---

# Tenant Module Documentation Index

**Last updated: 2026-07-28**

---

## Navigation

- [Overview](README.md) — Module description and quick start
- [Architecture](ARCHITECTURE.md) — System design and isolation strategies
- [API Reference](API.md) — Core models, contracts, and services
- [Patterns](PATTERNS.md) — Design patterns and best practices
- [Troubleshooting](TROUBLESHOOTING.md) — Common issues and solutions
- [Contributing](../../docs/wiki/how-to/contributing.md) — Development guidelines

---

## Module Statistics

**Last Generated: 2026-07-28**

| Category | Count | Description |
|----------|-------|-------------|
| Models | 15 | Tenant, Domain, TenantDomain, TenantSetting, TenantSubscription, etc. |
| Actions | 15 | Business logic components grouped by feature (Config, Domains, Models, etc.) |
| Services | 7 | Configuration resolvers, domain services, and utility services |
| Filament Resources | 7 | Admin panel resources and form components |
| Migrations | 3 | Database schema setup and evolution |
| Seeders | 9 | Database seed data for testing and development |
| Factories | 8 | Eloquent model factories for testing |
| Policies | 2 | Authorization policies for models |
| Traits | 4 | Reusable model traits |
| Providers | 4 | Service providers and registration |
| Contracts | 2 | Interfaces and abstraction contracts |
| Commands | 1 | Artisan console commands |

**Total: 78 PHP files**

---

## Recently Updated Files

| Date | File | Category |
|------|------|----------|
| 2026-07-28 | README.md | Documentation |
| 2026-07-28 | ARCHITECTURE.md | Documentation |
| 2026-07-28 | API.md | Documentation |
| 2026-07-28 | PATTERNS.md | Documentation |
| 2026-07-28 | TROUBLESHOOTING.md | Documentation |
| 2026-07-22 | Tenant.php | Model |
| 2026-07-22 | Domain.php | Model |
| 2026-07-22 | TenantDomain.php | Model |
| 2026-07-22 | TenantSubscription.php | Model |
| 2026-07-22 | TenantSetting.php | Model |

---

## Key Concepts

### Tenant Isolation
Each tenant operates in complete isolation:
- **Database Isolation**: Separate database per tenant or shared database with scoping
- **Configuration Isolation**: Per-tenant configuration settings
- **Domain Routing**: Automatic tenant resolution via domain/subdomain

### Core Models

- **Tenant**: Root tenant entity with settings and metadata
- **Domain**: Domain/subdomain associations for tenant routing
- **TenantDomain**: Junction model linking tenant to multiple domains
- **TenantSetting**: Key-value configuration storage
- **TenantSubscription**: Subscription and billing model

---

## Quick Links

- **Config**: `config/config.php`, `config/database.php`
- **Service Provider**: `app/Providers/TenantServiceProvider.php`
- **Contracts**: `app/Contracts/`
- **Tests**: `tests/` (refer to main project structure)

---

## Related Modules

- **[Xot](../../Xot/docs/INDEX.md)** — Core framework and abstractions
- **[User](../../User/docs/INDEX.md)** — User management and authentication

---

## Development Guidelines

1. Always maintain tenant isolation in queries
2. Use actions for complex business logic
3. Document patterns in PATTERNS.md
4. Add troubleshooting entries for known issues
5. Keep migrations atomic and reversible

For detailed development guidance, see [Contributing Guide](../../docs/wiki/how-to/contributing.md).
=======
title: "Tenant — Indice canonico docs"
status: canonical
module: Tenant
updated: 2026-10-20
---

> Indice canonico. Indici storici alternativi: `00-INDEX.md` (8.6 KB), `00-index.md` (5 KB), `INDEX.md` (3.7 KB, 2026-09-26, status draft), `INDEX_GENERATED.md`, `README.md`, `changelog.md`. Nessun file storico cancellato.

> Convenzione: [Docs Organization — Modules & Themes](../../Xot/docs/conventions/docs-organization.md)

# Tenant — Indice docs

Modulo Tenant (multi-tenancy, isolamento tenant, scoping database, RLS, tenant middleware, scope actions e resource multi-tenant).

## Panoramica
- [README.md](./README.md) — identità, scope, confini, multi-tenant architecture
- [ARCHITECTURE.md](./ARCHITECTURE.md) — architettura generale
- [API.md](./API.md) — endpoint API
- [PHILOSOPHY.md](./PHILOSOPHY.md) — filosofia del modulo
- [FRAMEWORKS.md](./FRAMEWORKS.md) — framework e dipendenze

## Architettura
- [architecture/](./architecture/) — analisi architetturale e struttura del modulo
- [models/](./models/) — modelli tenant-scoped
- [concepts/](./concepts/) — concetti architetturali (`xotbase-never-extend-filament.md`, `tenant-service-to-actions-migration.md`)
- [development/](./development/) — linee guida sviluppo
- [routes.md](./routes.md) / [routes/](./routes/) — rotte

## PHPStan / Qualità
- [phpstan.md](./phpstan.md) — analisi generale
- [phpstan-report.md](./phpstan-report.md) — report dettagliato
- [phpstan-fixes.md](./phpstan-fixes.md) — correzioni
- [phpstan-fix-plan/](./phpstan-fix-plan/) — piano di fix
- [phpstan-level10-fixes.md](./phpstan-level10-fixes.md) — livello massimo
- [quality/](./quality/) — report qualità, audit, standard
- [coverage.md](./coverage.md) — copertura test
- [QUALITY_REPORT.md](./QUALITY_REPORT.md) — report qualità

Gate 2026-10-20: `phpstan analyse Modules` → file_errors 0.

## BMAD / Stories
- [bmad/](./bmad/) — dossier BMAD (00-INDEX.md, architecture, quick-ref, epic, stories)
- [stories/](./stories/) — storie feature (`01.Tenant-phpstan-fix.story.md`, `multi-tenant-scope-isolation.story.md`, `monitoring-alerting-setup.story.md`)
- [bmad/stories/](./bmad/stories/) — storie BMAD

## Struttura (sottocartelle)
- `bmad/` — dossier BMAD
- `stories/` — storie feature
- `concepts/` — concetti architetturali
- `analysis/` — analisi
- `bugfix/` — fix bug
- `investigation/` — indagini
- `prompts/` — prompt
- `tasks/` — task
- `raw/` — raw data
- `outputs/` — output
- `screenshots/` — screenshot
- `wiki/` — wiki (se presente nel modulo; `wiki/index.md` non in docs ma nel modulo)
- `archive/` / `archive/` non in docs/ — elementi legacy mantenuti

## Duplicati storici mantenuti
- `00-INDEX.md` (8.6 KB, 2026-10-20) — indice operativo; mantenuto
- `00-index.md` (5 KB) — mantenuto
- `INDEX.md` (precedente, 3.7 KB, 2026-09-26, status draft) — mantenuto; questo file `INDEX.md` è il nuovo canonico
- `INDEX_GENERATED.md` — mantenuto
- `README.md` — mantenuto
- `CHANGELOG.md` / `changelog.md` — mantenuti
- `rules-index.md` — mantenuto
- `index.md` / `index-generated.md` / `index_generated.md` — mantenuti

---
*Aggiornato: 2026-10-20 — conforme a `docs-organization.md`; `00-INDEX.md` resta indice operativo; `INDEX.md` aggiornato a canonico; nessun file cancellato o rinominato.*
>>>>>>> .merge_file_5mvO40
