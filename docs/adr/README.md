---
title: "Architecture Decision Records"
type: index
tags: [adr, decisioni]
created: 2026-11-18
updated: 2026-11-26
qmd: "architecture decision records tenant metodo harness formato adr decisione contesto alternative scartate"
---

# Architecture Decision Records

## Metodo Harness

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR deve rendere leggibili contesto, driver, alternative, decisione, conseguenze e una conferma ripetibile; non è un diario né una spiegazione retroattiva inventata.

Le decisioni vanno verificate contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e collega il precedente come superseded/deprecated.

Il **perche'** delle scelte di questo pacchetto: una decisione per file, con le alternative scartate.
Il nome del file e' l'argomento, senza date ne' numeri (la data sta nella frontmatter).

## Formato

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
decision-makers: [team back office]
issues: []
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Driver della decisione
Le forze che pesano sulla scelta, in elenco; ogni voce verificabile nel codice o in un documento del repo.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non è stata scelta.

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.

## Conferma
Test (percorso e, se c'è, `--group`), comando eseguibile da `laravel/` o regola di review che falliscono se la decisione viene violata. Se non esiste una conferma automatica: «Nessuna conferma automatica oggi; proposta: …». Se il codice contraddice la decisione, prima di Conferma c'è `## Stato attuale`.
```

## Decisioni

| ADR | Stato | Perché | Conferma |
|---|---|---|---|
| [0001-module-connections-alias-default](0001-module-connections-alias-default.md) | accepted | Ogni modulo ha la sua connessione, alias della default se punta allo stesso database (transazioni tra moduli atomiche). | Sì: `Modules/Tenant/tests/Feature/ModuleConnectionAliasTest.php` |
| [0002-tenant-json-content-isolated-in-tests](0002-tenant-json-content-isolated-in-tests.md) | accepted | Nei test i JSON del tenant si scrivono in una copia sotto `storage/`, mai in `config/`. | Sì: `--group=TENANT-FILE-PATH-INV-3` |
| [0003-tenant-name-from-reversed-host](0003-tenant-name-from-reversed-host.md) | accepted | Il tenant è la cartella di config del dominio invertito, risolta da host, `app.url` e symlink. | Sì: `--group=TENANT-FILE-PATH-INV-2`, `TENANT-NAME-INV-2`, `TENANT-NAME-INV-3` |

Elenco con stato: [index.md](index.md).

## Stato di copertura

ADR: 3. Con conferma automatica (test o comando eseguibile da `laravel/`): 3. ADR 0003 ha una sezione «Stato attuale» con due scarti tra decisione e codice/test.

## Backlog

- Riscrivere `tests/Unit/Actions/GetTenantNameActionTest.php` con cartelle di config temporanee (ADR 0003, «Stato attuale»).
- `0000-template.md` è il modello, non una decisione.
