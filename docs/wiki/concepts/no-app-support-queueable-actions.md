---
title: "no app/Support — Tenant QueueableAction"
type: concept
tags: [tenant, actions, queueable-action, support, config, migration]
created: 2026-07-12
updated: 2026-07-13
qmd: "Tenant module no Support ConfigStringKeyFilter morph map merge config TenantService migration"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../../../../docs/wiki/concepts/no-app-support-monorepo-migration.md
  - config-merge-philosophy.md
---

# Tenant — `app/Support/` eliminato

| Legacy | Action |
|--------|--------|
| `ConfigStringKeyFilter::onlyStringKeys` | `Actions/Config/FilterConfigStringKeysAction` |
| `ConfigStringKeyFilter::mergeRecursive` | `Actions/Config/MergeRecursiveStringKeyConfigAction` |

## TenantService → Action dirette (2026-07)

`TenantService` (facade statica) **eliminata**. I caller usano `app(SomeAction::class)->execute(...)` — **non** `handle()`.

| Ex `TenantService::` | Action |
|----------------------|--------|
| `getName()` | `GetTenantNameAction` |
| `filePath($f)` | `GetTenantFilePathAction` |
| `config($k,$d)` | `ResolveTenantConfigValueAction` |
| `getConfigPath($k)` | `GetTenantConfigPathAction` |
| `getConfig($n)` | `GetTenantConfigArrayAction` |
| `saveConfig($n,$d)` | `SaveTenantConfigAction` |
| `getConfigNames()` | `GetTenantConfigNamesAction` |
| `modelClass($n)` | `ResolveTenantModelClassAction` |
| `model($n)` | `ResolveTenantModelInstanceAction` |
| `trans($k)` | `TranslateTenantKeyAction` |
| `allModules()` | `GetTenantModulesAction` |

Config tenant (`config/{tenant}/*.php`): `app(GetTenantFilePathAction::class)->execute('…')`.

Test: mockare l'Action rilevante (`app()->instance(GetTenantFilePathAction::class, $mock)`), non più `TenantService`.

## Perché

Config tenant e morph map devono ignorare chiavi non-string (PHPStan + merge sicuro). Static helper in Support impediva mock e coda; le Action restano pure e componibili nel `TenantServiceProvider` e trait Sushi.

## Collegamenti

- [no-app-support-monorepo-migration](../../../../docs/wiki/concepts/no-app-support-monorepo-migration.md)
