---
title: "Conflict Resolution — Module Tenant"
module: "Tenant"
type: concept
tags: [conflict, resolution, git]
created: 2026-07-14
updated: 2026-09-17
qmd: "conflict resolution"
related:
  - "./phpstan-corrections-january.md"
---
# Conflict Resolution — Module Tenant

> Merged from `conflict-resolutiones.md`, `conflict-resolution-fixes.md`, `conflicts.md`,
> `resolution-conflitti.md`, and `risoluzione-conflitti.md` on 2026-09-17 (all near-duplicate
> or empty-stub variants of this topic). History kept as dated sections below, oldest first.

## [2023-07-30] Domain/Rector/Filament merge conflicts

Conflitti Git identificati nel modulo Tenant il 30/07/2023, nei seguenti file:

1. `rector.php`
2. `app/Filament/Resources/DomainResource.php`
3. `app/Filament/Resources/DomainResource/Pages/CreateDomain.php`
4. `app/Filament/Resources/DomainResource/Pages/EditDomain.php`
5. `app/Models/Domain.php`
6. `app/Models/Traits/SushiToCsv.php`
7. `app/Models/Traits/SushiToJsons.php`
8. `app/Console/Commands/_components.json`

**rector.php**: tre versioni in conflitto (una con `Rector\Core\Configuration\Option` +
`PHPUnitLevelSetList`, una con `SetList`/`LaravelSetList` + helper `safe_object_call`, una con
`PHPUnitLevelSetList` + `LevelSetList` diretti). Risolto unificando i namespace, sostituendo
`safe_object_call` con chiamate dirette a `$rectorConfig`, e combinando le regole di tutte le
versioni.

**DomainResource.php**: due approcci al form schema (chiavi nominali con validazioni dettagliate
vs. definizione diretta senza chiavi). Mantenuta la versione con chiavi nominali e validazioni.

**CreateDomain.php**: tre versioni della classe base (`XotBaseCreateRecord` con namespace
completo, una duplicata, e la `CreateRecord` standard di Filament). Risolto con import esplicito
di `XotBaseCreateRecord`.

**_components.json**: conflitto di formattazione (compatta vs. formattata). Adottata la versione
formattata per leggibilità.

Test aggiunti: `tests/Unit/DomainTest.php` (istanziazione del modello `Domain`, funzionamento di
`getRows()` con mock di `GetDomainsArrayAction`).

Nota storica: un aggiornamento successivo non datato in questa stessa sezione menzionava un
conflitto in `app/Models/Tenant.php` tra relazioni verso moduli `Patient`/`Dental` — questi moduli
non esistono in questo progetto (probabile contaminazione da un template/altro progetto condiviso
tra i moduli Laraxot); annotazione conservata solo per memoria storica, non applicabile qui.

## [2024-12] Git conflict markers in TenantService.php (script automatico)

**Problema**: marker di conflitto Git in `app/Services/TenantService.php` causavano `ParseError`,
bloccando l'analisi PHPStan.

**Risoluzione**: selezione sistematica della "current change" (contenuto tra `=======` e
`>>>>>>>`) per tutti i conflitti — controlli `is_array()`, `throw new Exception`, `str_replace()`,
`isset()`, signature di `modelClass()`.

**Metodologia**:
1. Identificazione automatica di tutti i marker.
2. Selezione sempre della "current change".
3. Backup automatico prima delle modifiche.
4. Verifica che non rimangano marker di conflitto.

**Script**: `bashscripts/fix_git_conflicts_current_change.sh` v4.0 (algoritmo AWK, dry-run,
backup automatico).

**Risultato**: 0 marker residui, ParseError risolti, nessuna perdita di funzionalità.

## [undated] TenantServiceProvider.php — nested stash-on-merge conflict

- **Files resolved**: `app/Providers/TenantServiceProvider.php`, `docs/nestedset-migration-best-practices.md`
- **Strategy**: keep HEAD/local ("ours") side
- **Root cause**: nested stash-on-merge conflicts
- **Backlink**: root conflict resolution report (`../../../../docs/conflict-resolution-report.md`, project root — verify path before following, root docs tree has since been reorganized)
