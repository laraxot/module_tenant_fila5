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
>>>>>>> .merge_file_k8LnVQ
