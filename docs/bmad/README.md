<<<<<<< HEAD
---
title: "Tenant — Multi-Tenancy"
description: "Modulo per il multi-tenancy, isolamento dati per tenant"
module: "Tenant"
alias: "tenant"
version: "1.0.0"
priority: 2
active: true
status: "core-multi-tenancy"
author: "Team Laraxot"
license: "Proprietary"
php_version: "^8.1"
core_version: "10.0"
dependencies: ["Xot", "User"]
extends: []
extended_by: 0
documentation_date: "2026-05-27"
---

# Tenant — Multi-Tenancy

## Scopo

Tenant è il modulo che gestisce il multi-tenancy dell'ecosistema. Ogni `BaseTenant` ha `slug`, `domain`, `database` e una relazione `users()` con pivot `tenant_user`. È il layer che permette a più organizzazioni di coesistere in un'unica installazione.

## Religione

- **"Un database per tenant o row-level security"**: due politiche accettate, ma **mai mixate**
- **"Tenant è una primitiva, non un dettaglio"**: ogni modulo deve essere tenant-aware
- **"HasTenants trait su BaseUser"**: la relazione è nel trait, non in ogni modulo
- **"Salvataggio config con Action"**: `SaveTenantConfigAction` è il punto unico
- **"XotBase come fondamento"**: ogni risorsa tenant estende `XotBaseResource`

## Filosofia

Tenant crede che **l'isolamento dei dati sia un diritto, non un optional**. Ogni tenant ha la sua configurazione, le sue risorse, la sua sicurezza. Il sistema è progettato per **scalare orizzontalmente** aggiungendo tenant senza modificare il codice.

## Politica

- **Pivot `tenant_user`**: `tenant_id`, `user_id`, `permissions`
- **`SaveTenantConfigAction`**: unico punto per salvare config tenant
- **`HasTenants` trait**: relazione `tenants()` su `BaseUser`
- **Slug + domain**: identificazione tenant tramite slug o dominio
- **`BaseTenant::$connection`**: supporto per database separati

## Zen

> **"Il tenant è un confine. Il confine è una promessa. La promessa è la privacy."**

Lo Zen di Tenant è l'**isolamento**. I dati di un tenant non possono mai essere visti, modificati o cancellati da un altro tenant. È una promessa architetturale, non una feature.

## Perché esiste

Le applicazioni SaaS moderne hanno bisogno di multi-tenancy per servire più clienti con un'unica installazione. Tenant esiste per **gestire questa complessità** in modo standardizzato.

## Cosa Mancherebbe (Gap Analysis)

| Gap | Severità | Suggerimento |
|-----|----------|--------------|
| Manca tenant impersonation | Alta | Aggiungere `ImpersonateTenantAction` |
| Nessun sistema di tenant billing | Alta | Integrare con `Billing` per fatturazione per tenant |
| Manca tenant backup isolato | Media | Aggiungere `TenantBackup` con restore selettivo |
| Nessun sistema di tenant analytics | Media | Aggiungere `TenantAnalytics` per usage tracking |
| Manca cross-tenant reporting | Bassa | Aggiungere `CrossTenantReport` per admin globali |

---

*Documento generato secondo le convenzioni del progetto — modulo `Tenant` — data 2026-05-27*
=======
<<<<<<< .merge_file_uOg22l
<<<<<<< .merge_file_B50TGO
---
title: "Tenant — indice BMAD"
type: note
module: Tenant
tags:
  - bmad
  - tenant
  - indice
created: 2026-09-28
updated: 2026-09-28
qmd: "tenant bmad indice documentazione multi tenancy"
related:
  - architecture.md
  - architecture/module-boundary.md
  - architecture/tenant-config-resolution.md
  - brainstorming.md
  - brainstorming/module-opportunities.md
  - epics/tenant-config-resolution.md
  - quick-reference.md
  - setup-guide.md
---

# Tenant — indice BMAD

> **SUMMARY** — Indice dei documenti BMAD del modulo `Tenant` (`laravel/Modules/Tenant`).
> Il modulo fornisce multi-tenancy con isolamento dati via connessione DB, un registry di
> resolver di configurazione, il modello `Domain` e i trait "Sushi" per dataset JSON/CSV.
> Tutti i path in questo indice sono relativi a `laravel/Modules/Tenant/docs/bmad/`.

## Documenti canonici

| Documento | Path |
|-----------|------|
| Architettura (indice) | [architecture.md](architecture.md) |
| Architettura — confini di modulo | [architecture/module-boundary.md](architecture/module-boundary.md) |
| Architettura — risoluzione config | [architecture/tenant-config-resolution.md](architecture/tenant-config-resolution.md) |
| Brainstorming (indice) | [brainstorming.md](brainstorming.md) |
| Brainstorming — opportunità | [brainstorming/module-opportunities.md](brainstorming/module-opportunities.md) |
| Epic — risoluzione configurazione | [epics/tenant-config-resolution.md](epics/tenant-config-resolution.md) |
| Epic — roadmap | [epics/module-roadmap.md](epics/module-roadmap.md) |
| Quick reference | [quick-reference.md](quick-reference.md) |
| Setup guide | [setup-guide.md](setup-guide.md) |

## Codice del modulo in mappa rapida

| Area | Path |
|------|------|
| Models | `app/Models/` — `Tenant.php`, `Domain.php`, `DatabaseConfig.php`, `TenantSetting.php`, `TenantSubscription.php`, `TenantDomain.php`, `BaseModelJsons.php`, `TestSushiModel.php` |
| Actions | `app/Actions/` — `TenantAction.php`, `Config/`, `Domains/`, `Markdown/`, `Models/`, `Modules/`, `Translations/` |
| Services | `app/Services/` — `TenantService.php`, `Config/ConfigResolverRegistry.php`, `Config/ConfigStringKeyFilter.php`, `Config/Contracts/`, `Config/Resolvers/` |
| Filament | `app/Filament/Resources/DomainResource.php` (+ `Pages/`, `Schemas/`, `Tables/`), `app/Filament/Pages/Dashboard.php` |
| Policies | `app/Models/Policies/TenantBasePolicy.php`, `app/Models/Policies/DomainPolicy.php` |
| Providers | `app/Providers/TenantServiceProvider.php`, `app/Providers/RouteServiceProvider.php`, `app/Providers/EventServiceProvider.php`, `app/Providers/Filament/AdminPanelProvider.php` |
| Config | `config/config.php`, `config/database.php`, `config/modules.php`, `config/xra.php`, `config/metatag.php`, `config/test.php` |
| Lang | `lang/it/tenant.php`, `lang/it/domain.php`, `lang/it/domains.php`, `lang/it/domain_form.php`, `lang/it/domain_infolist.php`, `lang/en/tenant.php`, `lang/en/domain.php`, `lang/de/tenant.php`, `lang/de/domain.php` |
| Test | `tests/Unit/Actions/`, `tests/Unit/Models/`, `tests/Feature/`, `tests/Integration/`, `tests/Performance/` |
| Database | `database/migrations/2026_07_24_000000_create_tenant_settings_table.php`, `2026_07_24_000001_create_tenant_subscriptions_table.php`, `2026_07_24_000002_create_database_configs_table.php` |

## Metodo di riferimento

- [../../../Xot/docs/bmad-method.md](../../../Xot/docs/bmad-method.md) — metodo BMAD in Laraxot.
- [../../../Xot/docs/bmad/stories/5.249-bmad-docs-fleet-completion.story.md](../../../Xot/docs/bmad/stories/5.249-bmad-docs-fleet-completion.story.md) — campagna di completamento docs.
=======
=======
>>>>>>> .merge_file_h1KKXy
# Tenant Module

Modulo del sistema PTVX per la gestione delle risorse umane e valutazione delle performance nelle pubbliche amministrazioni.

## Descrizione

Il modulo Tenant si occupa di [DESCRIZIONE DA COMPLETARE].

## Dipendenze

- Xot (core)
- User (gestione utenti)
- Lang (internazionalizzazione)

## Come contribuire

1. Fork del repository
2. Creare un branch per la feature/fix
3. Seguire le convenzioni di codifica (PSR-12, array una chiave per riga)
4. Eseguire i test: 
5. Aprire una pull request

## Struttura

- `app/`: Codice sorgente (azioni, risorse, widget, ecc.)
- `database/`: Migrazioni e seeders
- `resources/`: Viste, lang, assets
- `docs/`: Documentazione (questo file)
- `tests/`: Test unitari e di integrazione

## Licenza

Proprietario - Laraxot
<<<<<<< .merge_file_uOg22l
>>>>>>> .merge_file_k8LnVQ
=======
>>>>>>> .merge_file_h1KKXy
>>>>>>> laraxot/dev
