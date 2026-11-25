---
tags: [documentation]
qmd: "docs index audit.story"
issues: []
discussions: []
title: "Tenant: audit e riorganizzazione indice docs/"
type: story
module: Tenant
slug: docs-index-audit
status: done
created: 2026-09-03
updated: 2026-09-03
owned_scope:
  - "laravel/Modules/Tenant/docs/index.md"
---
# Tenant: audit e riorganizzazione indice docs/

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

Audit di tutti i 426 file `.md` sotto `Modules/Tenant/docs/` e riscrittura di `index.md` come
indice organizzato per argomento (panoramica, architettura, config, filament, api, testing,
phpstan, conflitti/git, regole, roadmap, tasks, stories, wiki, llm-wiki, html2pdf, staging).

Nessun file esistente e' stato rinominato o cancellato. 115 doppioni/varianti case-sensitive,
typo o file superati (es. `api-2.md` vs `api-2.md`, `roadmap/` sequenza numerata vs nomi piatti,
`root-md-files/`/`root-txt-files/`/`raw/root-import/` come mirror ridondanti tra loro) sono
raggruppati nella sezione "Storico / da consolidare" di `index.md` con nota sul file canonico,
senza azione distruttiva in questo task.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
