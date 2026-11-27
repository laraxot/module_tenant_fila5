---
title: "ADR — modulo Tenant"
type: index
tags: [adr, decisioni, tenant, multi-sito]
created: 2026-11-18
updated: 2026-11-26
qmd: "architecture decision records tenant metodo harness formato adr decisione contesto alternative scartate"
---

# ADR del modulo Tenant

## Metodo Harness

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR deve rendere leggibili contesto, driver, alternative, decisione, conseguenze e una conferma ripetibile; non è un diario né una spiegazione retroattiva inventata.

Le decisioni vanno verificate contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e collega il precedente come superseded/deprecated.

Il **perche'** delle scelte di questo pacchetto: una decisione per file, con le alternative scartate.
Il nome del file e' `NNNN-argomento-in-kebab-case.md`, senza date (la data sta nella frontmatter); eccezioni: `README.md`, `index.md`, `0000-template.md`.

Leggili prima di toccare `GetTenantNameAction`, `GetTenantFilePathAction`, `TenantServiceProvider::registerDB()` o i
trait Sushi. Formato e regole: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

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

## Decisioni precedenti (formato libero, non ancora ADR)

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

## Harness minimo: ownership, evidenza e recupero (2026-11-27)

Questo indice appartiene a **module_tenant_fila5**: ogni decisione su codice, dominio o tema va nell'ADR del package owner; il root registra soltanto i vincoli di composizione. Un ADR richiede una scelta reale con alternative e conseguenze, più una **Conferma** ripetibile (oppure la dichiarazione esplicita che manca). Non creare ADR fittizi per riempire un indice.

- [Confine LaravelDay/harness Xot](https://github.com/laraxot/module_xot_fila5/blob/dev/docs/adr/0042-laravel-day-harness-adoption-boundary.md); [ownership root](https://github.com/laraxot/base_ptvx_fila5/blob/dev/docs/adr/0001-harness-minimo-e-ownership.md).
- **BMAD**: la story owner-local conserva `scope`, `must_not_change`, `evidence`, `approval_required` nei cambi rischiosi.
- **ECC**: nessun marker di merge; distinguere la prova eseguita dal semplice riferimento a un test; se la conferma non è disponibile segnare `non eseguita`.
- **Second Brain**: QMD/Graphify e `.harness/memory/{facts,lessons}.md` sono puntatori a evidenza datata, non copie degli ADR. [Runbook](https://github.com/laraxot/base_ptvx_fila5/blob/dev/docs/harness/README.md) · [Rollout #15](https://github.com/laraxot/base_ptvx_fila5/issues/15).
