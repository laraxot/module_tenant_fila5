---
qmd: ECC audit modulo Tenant verification security testing workflow
title: ECC audit operativo modulo Tenant
status: baseline-review
---

# ECC audit operativo modulo Tenant

## Contratto PTVX

Questo documento seleziona le verifiche ECC applicabili al modulo `Tenant`
senza sostituire AGENTS.md, BMAD o le regole locali. ECC deve produrre una
correzione minima, source-first, con lock prima dell'edit e gate dopo l'edit.

## Checklist

- [ ] `clean-code`: metodi piccoli, DRY, KISS, nessun wrapper inutile.
- [ ] `security-review`: policy, input, mass assignment, export, log e privacy.
- [ ] `laravel-verification`: route, config, migration additive e container.
- [ ] `verification-loop`: PHPStan level max + Pest mirato + diff check.
- [ ] `tdd-workflow`: test di regressione prima o insieme alla correzione.
- [ ] `documentation-sync`: story BMAD, indice modulo e QMD aggiornati.
- [ ] `context-engineering`: usare QMD/graphify prima e registrare il perché dopo.

## Input del modulo

- PHP app: 56
- test: 65
- policy: 2
- resource Filament: 1
- action: 19

## Procedura per ogni finding

1. Recuperare contesto da QMD e caller con `rg`.
2. Creare o aggiornare la story in `docs/bmad/stories`.
3. Acquisire lock sui file disgiunti.
4. Correggere la causa, non il messaggio PHPStan.
5. Eseguire il test minimo e poi i gate del modulo.
6. Registrare evidenza, limiti e follow-up nella story.

## Anti-pattern vietati

- baseline PHPStan o `@phpstan-ignore` senza motivazione verificata;
- test svuotati per nascondere un errore;
- migrazioni distruttive o accesso a dati sacri;
- screenshot, dati o comportamento inventati;
- documenti con date/timestamp nel nome;
- modifica di file già lockati da un altro agente.

## Esito

Baseline ECC creata. Il modulo non è dichiarato conforme finché gli acceptance
criteria del documento BMAD corrispondente non risultano verificati con output
dei gate.
