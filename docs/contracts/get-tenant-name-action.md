---
title: "Contratto — GetTenantNameAction"
type: contract
action: "Modules\\Tenant\\Actions\\GetTenantNameAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# GetTenantNameAction

Risolve il tenant corrente dall'host. Ogni file tenant (`GetTenantFilePathAction`, config, JSON CMS, lang) sta sotto `config/<nome>/`,
quindi un errore qui manda i dati di un ente su un altro. Perché: [ADR 0003](../adr/0003-tenant-name-from-reversed-host.md).
Sorgente: `app/Actions/GetTenantNameAction.php`.

## Input

- Nessun parametro. Legge `$_SERVER['SERVER_NAME']`, l'header `Host` (solo fuori dalla console) e `config('app.url')`.

## Output

- `string`: percorso del tenant sotto `config/` con separatore `/` (esempio `local/fixcity`), oppure `localhost`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-NAME-INV-1 | Se nessuna cartella di config corrisponde all'host, il risultato è `localhost` (ultimo ripiego della catena `?? 'localhost'` in `execute()`). | — (non dimostrato) |
| TENANT-NAME-INV-2 | L'host perde `www.`, è spezzato sui punti, ogni parte è passata da `Str::slug` e l'ordine è invertito (`foo.example.com` diventa `com/example/foo`). | `TENANT-NAME-INV-2` |
| TENANT-NAME-INV-3 | Si prova la cartella `config/<parti invertite>`; con più di due parti si prova anche quella senza l'ultima parte; poi l'host di `app.url` invertito; infine `localhost` (`resolveFromParts`, `resolveFromDefaultHost`). | `TENANT-NAME-INV-3` |
| TENANT-NAME-INV-4 | Se la cartella trovata è un symlink verso un'altra config (`eu/fixcity` verso `local/fixcity`), il nome è il percorso reale sotto `config_path()`, non l'alias (`tenantNameFromPath`). Se cade, Laravel non trova i file di config già caricati con il percorso reale. | — (non dimostrato) |
| TENANT-NAME-INV-5 | `SERVER_NAME` vuoto o di loopback (`127.0.0.1`, `::1`, `localhost`) è ignorato a favore dell'header `Host` (non in console), poi di `app.url` (`getServerName`, `requestHost`). Se cade, dietro `artisan serve` o proxy ogni dominio ricade sul tenant di ripiego. | — (non dimostrato) |
## Effetti collaterali

- Nessuna scrittura. Legge `config('app.url')`, il filesystem (`file_exists`, `realpath`) e la richiesta corrente. Nessun evento, coda o cache.

## Errori

- `FilesystemException` da `Safe\realpath` ripiega sul nome logico del percorso (`tenantNameFromPath`); un errore nel leggere la richiesta è inghiottito (`requestHost`).
- Limite noto: `hostFromUrl()` chiama `Safe\parse_url` senza `try`: un `app.url` non analizzabile lancia `Safe\Exceptions\UrlException` e fa fallire la risoluzione invece di cadere su `localhost`.

## Non fa

- Non crea cartelle o config per un tenant assente: cade su `localhost`.
- Non autentica né autorizza l'host e non usa il database: l'header `Host` è dato dal client, il nome tenant vale quanto la cartella che esiste per quel nome.
- Limite noto (dalla lettura del codice, non eseguito): con host vuoto (`app.url` vuoto e nessun `SERVER_NAME`) o fatto di soli punti, `buildConfigPath` dà la cartella `config/` stessa (`config_path('')` non aggiunge niente), `file_exists` è vero e `tenantNameFromPath`/`logicalTenantName` restituiscono stringa vuota: il nome non ricade su `localhost` e `GetTenantFilePathAction` punta a `config/<file>` senza tenant. Il test `tests/Unit/Actions/GetTenantNameActionTest.php` ('handles empty app url config') si aspetta `localhost`.
- Limite noto: `resolveFromDefaultHost` costruisce il percorso con `base_path('config/...')`, il resto con `config_path()`; coincidono solo finché la config sta in `base_path('config')`.
