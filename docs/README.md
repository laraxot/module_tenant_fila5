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
documentation_date: "2026-09-17"
---

# Tenant — Multi-Tenancy

## Scopo

Tenant è il modulo che gestisce l'isolamento a livello di **configurazione/ambiente**: ogni deployment
(`laravel/config/{env}/{tenant}/`) ha il proprio `app.php`, `database.php`, `modules_statuses.json`, ecc.,
risolti tramite `Modules\Tenant\Services\TenantService` (facade sottile) e le Actions in `app/Actions/Config/`.
Il modello `Modules\Tenant\Models\Tenant` (**non** `BaseTenant`) ha `slug`, `domain`, `database` e una
relazione `users(): HasMany`.

> **Non confondere** con `Modules\User\Models\BaseTenant`: quello è il tenant/organizzazione a livello
> applicativo (membership utente↔tenant tramite pivot `tenant_user`, relazione `users(): BelongsToMany` e
> trait `HasTenants` su `BaseUser`). I due concetti — ambiente di deployment (questo modulo) e organizzazione
> a cui un utente appartiene (modulo User) — coesistono e sono governati da codice diverso.
> Verificato 2026-09-17 contro `Modules/Tenant/app/Models/Tenant.php` e `Modules/User/app/Models/BaseTenant.php`.

## Religione

- **"Un database per tenant o row-level security"**: due politiche accettate, ma **mai mixate**
- **"Tenant è una primitiva, non un dettaglio"**: ogni modulo deve essere tenant-aware
- **"HasTenants trait su BaseUser"**: la relazione è nel trait, non in ogni modulo
- **"Salvataggio config con Action"**: `SaveTenantConfigAction` è il punto unico
- **"XotBase come fondamento"**: ogni risorsa tenant estende `XotBaseResource`

## Filosofia

Tenant crede che **l'isolamento dei dati sia un diritto, non un optional**. Ogni tenant ha la sua configurazione, le sue risorse, la sua sicurezza. Il sistema è progettato per **scalare orizzontalmente** aggiungendo tenant senza modificare il codice.

## Politica

- **Pivot `tenant_user`**: `tenant_id`, `user_id` (+ timestamps, soft delete); nessuna colonna `permissions` ad oggi
- **`SaveTenantConfigAction`**: unico punto per salvare config tenant
- **`HasTenants` trait**: relazione `tenants()` su `BaseUser`
- **Slug + domain**: identificazione tenant tramite slug o dominio
- **Campo `database`**: il modello `Tenant` prevede un campo `database` per la separazione; tutti i modelli
  del modulo estendono `Modules\Tenant\Models\BaseModel`, che fissa `protected $connection = 'tenant'`
  (connessione statica, il cui target è risolto per-deployment via config, non uno switch dinamico per-request)

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

*Documento generato secondo le convenzioni del progetto — modulo `Tenant` — corretto 2026-09-17 (risolto conflitto di merge, verificate le classi citate contro il codice)*
