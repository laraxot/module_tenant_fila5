---
<<<<<<< HEAD
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
title: documentazione modulo Tenant
module: Tenant
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo Tenant

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Multi-tenancy module for the Laraxot ecosystem: single application instance serving multiple tenants with data isolation.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Tenant/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Tenant`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| 00-INDEX | [00-INDEX.md](./00-INDEX.md) |
| 00-index | [00-index.md](./00-index.md) |
| METODI_DUPLICATI_ANALISI | [METODI_DUPLICATI_ANALISI.md](./METODI_DUPLICATI_ANALISI.md) |
| ON-DEMAND-PATTERN | [ON-DEMAND-PATTERN.md](./ON-DEMAND-PATTERN.md) |
| PERFORMANCE-OPTIMIZATION | [PERFORMANCE-OPTIMIZATION.md](./PERFORMANCE-OPTIMIZATION.md) |
| PRD | [PRD.md](./PRD.md) |
| PRODUCT_LAUNCH_PLAN | [PRODUCT_LAUNCH_PLAN.md](./PRODUCT_LAUNCH_PLAN.md) |
| PRODUCT_ROADMAP | [PRODUCT_ROADMAP.md](./PRODUCT_ROADMAP.md) |
| PRODUCT_STRATEGY | [PRODUCT_STRATEGY.md](./PRODUCT_STRATEGY.md) |
| PROJECT-STRUCTURE | [PROJECT-STRUCTURE.md](./PROJECT-STRUCTURE.md) |
| QMD-SETUP | [QMD-SETUP.md](./QMD-SETUP.md) |
| REDUNDANCY_ANALYSIS | [REDUNDANCY_ANALYSIS.md](./REDUNDANCY_ANALYSIS.md) |
| SPRINT_PLANNING | [SPRINT_PLANNING.md](./SPRINT_PLANNING.md) |
| SUSHI_TO_JSON_FIX_PLAN | [SUSHI_TO_JSON_FIX_PLAN.md](./SUSHI_TO_JSON_FIX_PLAN.md) |
| TODO | [TODO.md](./TODO.md) |
| USER_RESEARCH | [USER_RESEARCH.md](./USER_RESEARCH.md) |
| about | [about.md](./about.md) |
| activitylog | [activitylog.md](./activitylog.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| ai-methodologies | [ai-methodologies.md](./ai-methodologies.md) |
| alternatives | [alternatives.md](./alternatives.md) |
| api-integration | [api-integration.md](./api-integration.md) |
| app | [app.md](./app.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| arr-first-vs-collect-first-decision | [arr-first-vs-collect-first-decision.md](./arr-first-vs-collect-first-decision.md) |
| arr-first-vs-collect-first-ision | [arr-first-vs-collect-first-ision.md](./arr-first-vs-collect-first-ision.md) |
| auth | [auth.md](./auth.md) |
| best-practices | [best-practices.md](./best-practices.md) |
| business-logic-deep-dive | [business-logic-deep-dive.md](./business-logic-deep-dive.md) |
| case-sensitivity-rules | [case-sensitivity-rules.md](./case-sensitivity-rules.md) |
| chaos-monkey-tenant-isolation-checklist | [chaos-monkey-tenant-isolation-checklist.md](./chaos-monkey-tenant-isolation-checklist.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| codex-error-fix | [codex-error-fix.md](./codex-error-fix.md) |
| confidence_guidelines | [confidence_guidelines.md](./confidence_guidelines.md) |
| configuration-logic-analysis | [configuration-logic-analysis.md](./configuration-logic-analysis.md) |
| configuration | [configuration.md](./configuration.md) |
| conflict-resolution-fixes | [conflict-resolution-fixes.md](./conflict-resolution-fixes.md) |
| conflict-resolution | [conflict-resolution.md](./conflict-resolution.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.
>>>>>>> 1ad0554 (.)
