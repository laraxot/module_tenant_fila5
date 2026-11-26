---
title: "Indice degli ADR — Tenant"
type: index
module: Tenant
status: active
updated: 2026-11-26
---

# Indice degli ADR — Tenant

| ADR | Stato | Perché | Conferma |
|---|---|---|---|
| [0001-module-connections-alias-default](0001-module-connections-alias-default.md) | accepted | Ogni modulo ha la sua connessione, alias della default se punta allo stesso database (transazioni tra moduli atomiche). | Sì: `Modules/Tenant/tests/Feature/ModuleConnectionAliasTest.php` |
| [0002-tenant-json-content-isolated-in-tests](0002-tenant-json-content-isolated-in-tests.md) | accepted | Nei test i JSON del tenant si scrivono in una copia sotto `storage/`, mai in `config/`. | Sì: `--group=TENANT-FILE-PATH-INV-3` |
| [0003-tenant-name-from-reversed-host](0003-tenant-name-from-reversed-host.md) | accepted | Il tenant è la cartella di config del dominio invertito, risolta da host, `app.url` e symlink. | Sì: `--group=TENANT-FILE-PATH-INV-2`, `TENANT-NAME-INV-2`, `TENANT-NAME-INV-3` |

Formato e regole: [README](README.md).
