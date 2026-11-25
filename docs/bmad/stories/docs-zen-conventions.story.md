---
title: "Tenant — bonifica docs .md (convenzioni zen)"
type: story
status: done
module: Tenant
epic: docs-second-brain
created: 2026-11-25
updated: 2026-11-25
parent: ../../../../Xot/docs/bmad/stories/docs-zen-conventions-swarm.story.md
qmd: "tenant docs bonifica template fabbricati product roadmap sprint planning user research frontmatter qmd"
---
# Tenant — bonifica docs `.md`

## Context and Problem Statement

Lane C dello swarm `laravel/Modules/Xot/docs/bmad/stories/docs-zen-conventions-swarm.story.md`: nomi e
frontmatter erano gia' a norma, restava rumore da template generici e 4 file senza `qmd`.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Perche'

Lane C dello swarm `laravel/Modules/Xot/docs/bmad/stories/docs-zen-conventions-swarm.story.md`: nomi e
frontmatter erano gia' a norma, restava rumore da template generici e 4 file senza `qmd`.

## Prima / Dopo

| Metrica | Prima | Dopo |
|---|---:|---:|
| file `.md` | 440 | 429 (con questa story) |
| copie esatte (md5) | 0 | 0 |
| nomi datati | 0 | 0 |
| non kebab | 0 | 0 |
| senza frontmatter | 0 | 0 |
| senza `qmd` | 4 | 0 |
| annidamenti generati | 0 | 0 |

## Cosa e' stato eliminato e perche'

Template fabbricati senza alcuna classe/tabella/comando del modulo verificabile nel codice
(`Owner: Product Team`, TAM/SAM/SOM, sprint con date inventate, checklist generiche):
`confidence-guidelines`, `duplicate-methods-report` (grep cross-modulo stantio), `launch-plan`, `launch`,
`product-launch-plan`, `product-roadmap`, `product-strategy`, `research`, `sprint-planning`, `sprint`,
`strategy`, `user-research`. Nessun link residuo (verificato).

Aggiunto `qmd` a `ente-data.md`, `adr/README.md`, `contracts/README.md`,
`contracts/create-json-file-by-record-action.md` (riparato anche lo YAML: FQCN con backslash in doppi apici).

## Casi lasciati in dubbio

- `duplicate-files-to-remove.md`: nota operativa su file reali del modulo (case-sensitivity test), lasciata.
- `roadmap.md` / `roadmap/*` / `roadmap-renamed.md` / `roadmap-miglioramenti.md` / `phpstan-roadmap.md`:
  roadmap multiple e stantie ("Level 0", "2025") ma non copie esatte; da consolidare a mano.
- `product-requirements.md`: semi-generico, lasciato.

## Gate

Solo `.md`: PHPStan/Pint/Pest non applicabili (skip documentato; PHPStan gia' 0). Verifica: misura ripetuta,
YAML frontmatter parse 0 errori, 0 riferimenti a file rimossi.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
