---
title: "Continuazione BMAD — Domani (chiusura 7.1/7.2 sushi PHPStan + profile-contract stale)"
type: module-fix
scope: Tenant
epic: "7"
bmad_version: v3.30.1
updated_at: '2026-09-22'
status: in-progress
related:
  - ../../stories/7.1.phpstan-sushi-boundaries.story.md
  - ../../stories/7.2.phpstan-test-harness-contracts.story.md
  - ../../stories/21-1-replace-profile-model-with-contract.md
  - ../../stories/git-state-conflict-marker-daemon-cleanup.story.md
---

# Tenant — Continuazione Domani

## Stato verificato ora (sessione 2026-09-22)

- Marker di conflitto: `35353af` (fix, dopo la story dedicata `828c1da`) ha ripulito la regressione del daemon; verificato ora con `grep -rIl "<<<<<<<" .` su tutto il modulo (esclusi vendor/.git): **0 hit reali** — i soli 2 file trovati (`docs/merge-conflicts-list.md`, `docs/wiki/troubleshooting/git-merge-conflict-inventory.md`) sono documentazione *sul* problema, non marker live.
- **Il daemon auto-commit e' attivo ora, in questa stessa sessione**: e' arrivato un nuovo commit `b91acc6` (`.`, autore Marco Xot) che ha committato `docs/bmad/architecture.md` e questo stesso file (boilerplate generico, prima untracked) — stessa firma gia' documentata in `git-state-conflict-marker-daemon-cleanup.story.md`. `dev` risulta comunque allineato a `laraxot/dev` (0 ahead/behind).
- `@phpstan-ignore trait.unused` presente in `app/Models/Traits/SushiToPhpArray.php:16` — coerente con l'owned scope di `7.1.phpstan-sushi-boundaries.story.md` (quel trait e' esplicitamente nello scope), non un problema nuovo.
- 0 `TODO`/`FIXME`/`dddx` in `app/` (grep pulito).

## Priorita' #1 domani — chiudere il ciclo 7.1/7.2 sushi PHPStan (probabile falso "in-progress")

`7.1.phpstan-sushi-boundaries.story.md` (status `in-progress`) documenta che l'AC#1 module-wide era bloccato da 40 diagnostiche PHPStan in test **non posseduti da 7.1** (owned scope = 4 trait Sushi + 1 Action + `DomainModelTest.php`). Quei 40 findings erano owned esattamente da `7.2.phpstan-test-harness-contracts.story.md` (status `review`), il cui Dev Agent Record dichiara gia' verificato: baseline 40 → `cold phpstan analyse Modules/Tenant`: **0 errors, 0 file errors**, Pest mirato 75 passed / 311 assertions. Le due story non sono mai state riallineate: 7.1 resta `in-progress` con l'ultimo task (`Aggiornare sushi-traits-phpstan-fixes.md e rieseguire PHPStan`) ancora `[ ]`. Domani: rieseguire `phpstan analyse Modules/Tenant --no-progress` a freddo per confermare lo 0 dichiarato da 7.2, poi promuovere 7.1 e 7.2 a `done` in un solo giro (evitare di rilavorare da zero qualcosa gia' chiuso).

## Altri task aperti, in ordine di priorita'

1. `docs/stories/21-1-replace-profile-model-with-contract.md` (status `todo`, epic 21) — l'unico file target elencato (`app/Models/TenantSubscription.php`, presunta `@property-read \Modules\Quaeris\Models\Profile|null $deleter`) **non contiene piu' ne' `Profile` ne' `deleter`** (verificato leggendo il file corrente, 63 righe, grep senza match; `git log -S Profile -- app/Models/TenantSubscription.php` non mostra storia per quella stringa in questo file). La premessa della story sembra gia' risolta altrove (o mai stata vera nella forma descritta) — da chiudere come `done`/`obsolete` dopo un doppio controllo, non da rilavorare come se fosse ancora da fare.
2. Story `3.5.multi-tenant-scope-isolation.story.md`, `3.8.verify-rls-policies.story.md`, `5.8.monitoring-alerting-setup.story.md`, `6.1.setup-wizard-db-init-seed.story.md` — tutte `status: backlog` in `docs/stories/`, nessuna evidenza raccolta in questa sessione che siano state iniziate; restano backlog reale, non azione per domani se non un re-triage di priorita'.
3. Rischio daemon: se al prossimo giro ricompaiono marker `<<<<<<<`/`=======`/`>>>>>>>` in `docs/` o `app/`, **non** fare `git checkout -- <file>` alla cieca (nota gia' scritta in `git-state-conflict-marker-daemon-cleanup.story.md`) — verificare prima con `git show <ref>:<path>` quale versione e' quella buona, come fatto in `35353af`.

## Second brain

`qmd query` su "Tenant sushi phpstan 7.1 7.2 40 findings zero" prima di riprendere (per non ri-diagnosticare da zero il disallineamento status); `qmd update` dopo la chiusura del punto 1.
