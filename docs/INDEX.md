---
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
