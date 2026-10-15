---
<<<<<<< .merge_file_jN9t7h
title: "Tenant — PHPStan e qualità (canonica)"
type: reference
status: stable
source_of_truth: true
module: Tenant
created: 2026-09-26
updated: 2026-10-15
tags: [phpstan, quality, tenant, sushi, standing-order]
qmd: "tenant phpstan zero errori sushi to json standards compliance report quality gate no ignore baseline"
related:
  - ./phpstan-standards.md
  - ./README.md
  - ./00-index.md
  - ../../../../bashscripts/docs/prompts/11-phpstan.md
  - ../../../../bashscripts/ai/wiki/memories/phpstan-quality-docs-bmad-standing-order.md
issues: []
discussions: []
---
=======
title: "phpstan"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan"
issues: []
discussions: []
status: draft
---

# PHPStan Level 10 Roadmap - Tenant Module
>>>>>>> .merge_file_TkrniZ

# Tenant: PHPStan e qualità

Canonica del modulo per il gate statico. I report numerici storici sotto restano
come evidence, non come stato corrente.

## Scopo

Tenant risolve il **tenant da host** (cartella `config/<tenant>/`) e espone
storage Sushi JSON/CSV/PHP. PHPStan serve a proteggere quel contratto: tipi
reali su trait, modelli e test, senza silenziatori.

## Gate

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Tenant
# chiusura swarm / consegna:
cd laravel && ./vendor/bin/phpstan analyse Modules
```

- `laravel/phpstan.neon` immutabile (solo utente umano).
- Vietati: `@phpstan-ignore*`, baseline, `assert()`, `@var`/cast solo per zittire.
- Parti dallo **scopo** del codice (Sushi, config per host, morph map), poi causa
  radice, poi fix. Prompt: [11-phpstan.md](../../../../bashscripts/docs/prompts/11-phpstan.md).
- Standing order:
  [phpstan-quality-docs-bmad-standing-order.md](../../../../bashscripts/ai/wiki/memories/phpstan-quality-docs-bmad-standing-order.md).

## Knowledge riusabile

| Argomento | File |
|-----------|------|
| Standard tipi SushiToJson / SushiToJsons | [phpstan-standards.md](./phpstan-standards.md) |
| Identità e flusso tenant | [README.md](./README.md) |
| Pattern di fix (wiki) | [wiki/concepts/phpstan-fix-patterns.md](./wiki/concepts/phpstan-fix-patterns.md) |

## Duplicati storici (superseded)

Non creare nuovi `phpstan-fixes-*` / `phpstan-corrections-*`. Aggiorna questa
pagina o una story in `docs/stories/` / `docs/bmad/stories/`.

| File | Nota |
|------|------|
| [phpstan-compliance.md](./phpstan-compliance.md) | claim L9 datato — superseded |
| [phpstan-compliance-status.md](./phpstan-compliance-status.md) | superseded |
| [phpstan-report.md](./phpstan-report.md) | output grezzo — superseded |
| [phpstan-fixes.md](./phpstan-fixes.md) e varianti `*-january*`, `*-gennaio*`, `*-corrections*` | diary di sessione — superseded |
| [phpstan-errors-roadmap.md](./phpstan-errors-roadmap.md), [phpstan-roadmap.md](./phpstan-roadmap.md) | roadmap storica — superseded |

Prima di un nuovo `.md`: `python3 -I bashscripts/tools/docs/md-filenames.py name <percorso>`
e cerca duplicati (`rg`/QMD). Nomi senza date/timestamp; link relativi.

## Verifica

Rimisura sempre: i numeri di un report vecchio non sono prova. Story BMAD del
modulo per cause/fix/output; git forward-only.
