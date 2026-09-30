---
title: "Tenant — Architettura BMAD"
type: note
module: Tenant
tags:
  - bmad
  - tenant
  - architettura
  - indice
created: 2026-09-28
updated: 2026-09-28
qmd: "tenant architettura mappa moduli modelli azioni"
related:
  - README.md
  - module-boundary.md
  - tenant-config-resolution.md
  - ../brainstorming.md
  - ../quick-reference.md
---

# Tenant — Architettura (indice)

> **SUMMARY** — Indice degli shard di architettura del modulo `Tenant` più la mappa
> sintetica del modulo. Il dettaglio lives negli shard; questo file non li duplica.

## Shard

| Shard | Path | Contenuto |
|-------|------|-----------|
| Confini di modulo | [architecture/module-boundary.md](architecture/module-boundary.md) | cosa entra e cosa esce dal dominio Tenant |
| Risoluzione config | [architecture/tenant-config-resolution.md](architecture/tenant-config-resolution.md) | resolver, morph map, connessione DB, provider |

## Mappa sintetica

| File | Responsabilita |
|------|----------------|
| `app/Providers/TenantServiceProvider.php` | unico bootstrapping: connessione DB, morph map, merge config |
| `app/Services/TenantService.php` | facade di dominio: `getName()`, `getConfig()`, `getConfigArray()`, `saveConfig()`, `getConfigNames()`, `getModelClass()`, `getModelInstance()`, `getTranslation()`, `getModules()` |
| `app/Services/Config/ConfigResolverRegistry.php` | registry dei resolver di chiavi config |
| `app/Models/Tenant.php` | tenant canonico; relazione `users()` verso la classe utente risolta a runtime |
| `app/Models/Domain.php` | dominio; `getRows()` delega a `GetDomainsArrayAction` |
| `app/Models/DatabaseConfig.php` | configurazione DB per tenant |
| `app/Models/TenantSetting.php`, `app/Models/TenantSubscription.php`, `app/Models/TenantDomain.php` | dati di tenant con tabella dedicata |
| `app/Models/BaseModelJsons.php` | base per modelli "Sushi" (dataset statici) |
| `app/Models/Traits/SushiToJson.php` | lettura/scrittura dataset JSON (`getJsonFile()`, `getRows()`, `getSushiRows()`, `loadExistingData()`, `saveToJson()`) |
| `app/Models/Traits/SushiToCsv.php`, `SushiToJsons.php`, `SushiToPhpArray.php` | varianti del trait Sushi |
| `app/Contracts/SushiToJsonContract.php`, `app/Contracts/SushiToJsonsContract.php` | contratti dei trait Sushi |
| `app/Filament/Resources/DomainResource.php` | unica risorsa Filament del modulo (`XotBaseResource`, model `Domain`) |
| `app/Models/Policies/TenantBasePolicy.php` | policy base con `before()` |
| `app/Models/Policies/DomainPolicy.php` | ability CRUD su `Domain`, estende `TenantBasePolicy` |

## Dipendenze

- `Modules\Xot\Contracts\UserContract` usato da `app/Models/Tenant.php` e
  `app/Models/Policies/TenantBasePolicy.php`.
- `Modules\Xot\Datas\XotData` usato da `app/Models/Tenant.php`.
- `XotBaseServiceProvider` / `XotBaseResource` come basi (provider e risorsa Filament).

## Test

Copertura concentrata in `tests/Unit/Actions/` (Config, Domains, Models, Markdown,
`GetTenantNameActionTest`, `TenantAdditionalActionsTest`), `tests/Unit/Models/`,
`tests/Unit/TenantModelsTest.php`, `tests/Unit/DomainTest.php`,
`tests/Feature/TenantBusinessLogicTest.php`, `tests/Feature/TenantConfigIsolationTest.php`,
`tests/Integration/`, `tests/Performance/`.

## Punto aperto verificato

`app/Models/Tenant.php` esiste e ha factory/seeders dedicati
(`database/factories/TenantFactory.php`, `database/seeders/TenantSeeder.php`), ma in
`database/migrations/` esistono solo tre migrazioni:
`2026_07_24_000000_create_tenant_settings_table.php`,
`2026_07_24_000001_create_tenant_subscriptions_table.php`,
`2026_07_24_000002_create_database_configs_table.php`.
Nessuna migrazione nel modulo crea la tabella `tenants`: va chiarito se è creata da un
altro modulo o se manca. Tracciato in [epics/tenant-config-resolution.md](epics/tenant-config-resolution.md).
