---
type: story
slug: phpstan-safe-preg-stringable
title: "PHPStan: Safe\\preg_replace sostituito da Str::of()->replaceMatches()"
status: done
phase: DONE
owner: Tenant
related:
  - "../../../Xot/docs/stories/phpstan-safe-preg-stringable.story.md"
created: 2026-11-12
updated: 2026-11-12
qmd: "phpstan safe preg stringable story safepregreplace"
---
# PHPStan: Safe\preg_replace e stringhe

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

`Safe\preg_replace` dichiara `string|array` anche per un input stringa. I punti del modulo che subito dopo usavano il risultato come stringa
ora passano da `Str::of(...)->replaceMatches(...)->toString()`. Motivazione e elenco completo sono nella story omonima di Xot.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
