---
id: Tenant/module-audit
title: "Audit brownfield del modulo Tenant"
status: in-progress
epic: module-quality
module: Tenant
qmd: "Tenant audit architettura qualità PHPStan Pest BMAD"
references:
  - ../00-index.md
  - ../../../../Xot/docs/ecc/00-index.md
---

# Audit del modulo Tenant

## Scopo e confini

Questo documento è l'artefatto BMAD di ricognizione del modulo Tenant. Descrive
solo evidenze presenti nel worktree e separa i fatti verificati dalle attività
ancora da eseguire. Il modulo appartiene all'applicazione Laravel modulare;
le decisioni applicative devono restare nelle classi e nei test del modulo,
mentre le convenzioni trasversali restano in Modules/Xot.

## Inventario iniziale verificato

| Area | Conteggio | Evidenza/interpretazione |
|---|---:|---|
| PHP sotto app/ | 56 | superficie applicativa da mappare per responsabilità |
| PHP sotto tests/ | 65 | contratti automatizzati presenti |
| Markdown sotto docs/ | 522 | patrimonio documentale da deduplicare e indicizzare |
| Marker Git in PHP/JSON/YAML | 0 | controllo iniziale senza marker nei formati analizzati |
| composer.json/module.json | validi | parsing JSON riuscito |

## Audit BMAD

- Analisi: identificare responsabilità, dipendenze, entry point, Actions,
  modelli, policy, risorse Filament, rotte, migrazioni e flussi di test.
- Architettura: verificare che la logica di dominio resti nelle Queueable
  Actions e che le estensioni Filament usino le basi Xot previste.
- Qualità: eseguire PHPStan level massimo sul solo modulo, Pint/PHP lint sui
  file toccati e Pest in ambiente testing non produttivo.
- Rischi: cercare duplicazioni, merge irrisolti, import morti, cast da mixed,
  test vuoti, documentazione ridondante e nomi Markdown instabili.
- Piano: ogni finding deve diventare una story BMAD nel modulo con owner,
  acceptance criteria, evidenza e gate; nessun finding viene chiuso per il solo
  fatto che PHPStan non lo segnali.

## Gate ancora da eseguire

    cd laravel
    php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Tenant --no-progress
    php -l Modules/Tenant/app/<file>.php
    ./vendor/bin/pest Modules/Tenant/tests --no-coverage

Il risultato del comando PHPStan e del gate Pest non è dichiarato qui finché non
è stato eseguito e registrato con output osservabile. Non usare baseline,
ignoreErrors, database distruttivi o Git LFS.

## Deliverable successivi

1. mappa architetturale e confini del modulo;
2. inventario dei flussi utente e dei contratti dati;
3. registro dei finding classificati per rischio;
4. backlog BMAD con stories verificabili;
5. indice QMD aggiornato dopo ogni modifica documentale.

## Stato

**In progress.** L'inventario statico è verificato; l'audit semantico e i gate
per-modulo devono ancora essere completati.

