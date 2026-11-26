---
title: "ADR — Il tenant è la cartella di config del dominio invertito"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-26
related:
  - ../../app/Actions/GetTenantNameAction.php
  - ../../app/Actions/Config/GetTenantFilePathAction.php
qmd: "tenant name from reversed host cartella"
module: Tenant
decision-makers: [team back office]
---

# ADR: il tenant è la cartella di config del dominio invertito

## Contesto

- Lo stesso codice serve più siti; ogni sito ha la sua config (`database.php`, `xra.php`, contenuti JSON) versionata
  in `laravel/config/<percorso del tenant>/`.
- Il tenant non ha un record in database che lo identifichi a ogni richiesta: va ricavato dall'host prima che la
  connessione al database sia configurata (`TenantServiceProvider::registerDB()` legge proprio `database.php` del tenant).
- Il dibattito tra `config/<sito>.<ambiente>/` e `config/<ambiente>/<sito>/` era in `docs/tenant-config-path-philosophy-debate.md`, cancellata nel commit `7be34d6` e recuperabile con `git -C laravel/Modules/Tenant show 7be34d6^:docs/tenant-config-path-philosophy-debate.md`.
- Domanda: come si passa da host a cartella in modo deterministico, anche dietro proxy e in console?

## Driver della decisione

- Il tenant va ricavato dall'host prima che la connessione al database sia configurata: `TenantServiceProvider::registerDB()` legge il `database.php` del tenant.
- Lo stesso codice serve più siti, ciascuno con config versionata in `laravel/config/<percorso>/`: aggiungere un sito deve costare una cartella (o un symlink per un alias di dominio).
- La risoluzione deve essere deterministica anche dietro proxy e in console (`SERVER_NAME` di loopback, header `Host`, `app.url`).
- Un host imprevisto non deve produrre un percorso arbitrario: ogni parte è sluggata e la cartella deve esistere.

## Alternative scartate

- Tabella `tenants` interrogata a ogni richiesta: serve il database prima di sapere quale database usare.
- `config/<sito>.<ambiente>/`: mescola ambiente e sito, non scala su staging e produzione dello stesso sito (debate).
- Variabile d'ambiente per sito: un'installazione multi-dominio dovrebbe avere un processo per dominio.

## Decisione

`Modules/Tenant/app/Actions/GetTenantNameAction.php`:
- host = `SERVER_NAME`; se è `127.0.0.1`, `::1` o `localhost` (es. `php artisan serve`, proxy inverso) si usa l'header
  `Host` della richiesta, mai in console; altrimenti l'host di `app.url`;
- si toglie `www.`, si slugga ogni parte e si inverte: `foo.example.com` → `com/example/foo`;
- vince la prima cartella esistente tra il percorso completo e quello senza l'ultima parte; poi l'host di `app.url`;
  infine `localhost`;
- se la cartella è un symlink si restituisce il percorso reale rispetto a `config/`, perché le chiavi di config caricate
  da Laravel usano quello.
Ogni file del tenant si raggiunge con `GetTenantFilePathAction` (`config/<tenant>/<file>`), che rifiuta percorsi assoluti,
`..` e byte NUL.

## Conseguenze

- Pro: aggiungere un sito = aggiungere una cartella (o un symlink per un alias di dominio).
- Contro: l'host decide quale config si carica; un host non previsto ricade su `app.url` o `localhost`, mai su un
  percorso arbitrario (i nomi sono sluggati).
- Debito: `Modules/Xot/app/Actions/Config/GetTenantConfigPathAction.php` duplica `Config/GetTenantConfigPathAction` di
  questo modulo.

## Stato attuale

Il codice di oggi segue la decisione, con due scarti trovati leggendolo il 2026-11-26 (Pest non eseguito):

- `tests/Unit/Actions/GetTenantNameActionTest.php` (righe 9 e 18) si aspetta `com/example/myapp`, ma né `laravel/config/com/example/myapp` né `laravel/config/com/example` esistono (`resolveFromParts` richiede la cartella): con il codice attuale il risultato ripiega sull'host di `app.url` e infine su `localhost`, mai su `com/example/myapp`. Il test va riscritto con cartelle temporanee, come fa `tests/Unit/TenantGapsCoverageTest.php`.
- Con host vuoto (`app.url` vuoto e nessun `SERVER_NAME`) `buildConfigPath` dà la cartella `config/` stessa e il nome risolto è stringa vuota invece di `localhost` (`GetTenantNameAction::tenantNameFromPath`/`logicalTenantName`). Limite annotato in [get-tenant-name-action](../contracts/get-tenant-name-action.md).

## Conferma

- `cd laravel && vendor/bin/pest Modules/Tenant/tests --group=TENANT-FILE-PATH-INV-2`: nome file con traversal rifiutato (`tests/Feature/TenantConfigIsolationTest.php`, `tests/Unit/Actions/Config/GetTenantFilePathActionTest.php`).
- `cd laravel && vendor/bin/pest Modules/Tenant/tests --group=TENANT-NAME-INV-2` e `--group=TENANT-NAME-INV-3`: host `www.foo.example.com` risolto su `com/example` (parti accorciate) e ripiego su `app.url` (`tests/Unit/TenantGapsCoverageTest.php`).
- `tests/Feature/TenantConfigIsolationTest.php`, test `rejects malicious server name with path traversal`: un host con `../` ricade su `localhost` (nessun group).
- Contratti: [get-tenant-name-action](../contracts/get-tenant-name-action.md), [get-tenant-file-path-action](../contracts/get-tenant-file-path-action.md).
