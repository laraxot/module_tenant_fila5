---
title: "ADR — Ogni modulo ha la sua connessione, alias della default se punta allo stesso database"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Providers/TenantServiceProvider.php
---

# ADR: ogni modulo ha la sua connessione, alias della default se punta allo stesso database

## Contesto

- I modelli di ogni modulo dichiarano una connessione col nome del modulo (es. `protected $connection = 'user'` in
  `Modules/User/app/Models/BaseModel.php`, `'employee'` in `Modules/Employee/app/Models/BaseModel.php`): così un'installazione
  può mettere un modulo su un database diverso solo con la config.
- Nella maggior parte delle installazioni tutti i moduli stanno sullo stesso database. Con una connessione PHP per modulo,
  una transazione che scrive su due moduli non è atomica: il commit avviene connessione per connessione.
- Domanda: come tenere la possibilità del database separato senza perdere le transazioni tra moduli?

## Decisione

In `TenantServiceProvider::registerDB()`:
- `mergeModuleConnections()`: per ogni modulo attivo senza connessione dichiarata nel `database.php` del tenant, la
  connessione `<modulo in snake_case>` è una copia della default;
- `aliasModuleConnectionsToDefault()`: per quelle connessioni `DB::extend()` restituisce **la stessa istanza**
  `Connection` della default finché la config coincide (`hasSameDatabaseConfig()`, chiave `name` esclusa); una config
  diversa (dichiarata nel tenant o cambiata a runtime) apre una connessione propria.

## Alternative scartate

- Tutti i modelli sulla connessione di default: si perde la possibilità di separare un modulo (es. utenti su un database
  condiviso tra più siti).
- Una connessione per modulo senza alias: transazioni cross-modulo non atomiche e una sessione al database per modulo.
- Transazioni annidate su più connessioni: non danno atomicità (nessun two-phase commit).

## Conseguenze

- Pro: `DB::transaction()` copre scritture su più moduli; una sola sessione per richiesta nel caso comune.
- Contro: chi dichiara un modulo su un database diverso perde l'atomicità con gli altri moduli; nessuna FK tra database
  diversi (vedi l'ADR `user-id-string-columns-without-cross-db-fk` del modulo Employee).

## Verifica

`Modules/Tenant/tests/Feature/ModuleConnectionAliasTest.php`: config uguale → stessa istanza; config diversa → istanza
diversa (2 test verdi).
