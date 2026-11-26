---
title: "Indice operativo dei contratti — Tenant"
type: index
module: Tenant
status: active
updated: 2026-11-26
---

# Indice operativo dei contratti — Tenant

Registro generato dai contratti presenti in questa cartella (ADR 0012 di Xot). Copertura = invarianti con `->group('<ID>')` in `tests/` del modulo, contate il 2026-11-26. Comandi da `laravel/`; un gruppo = una promessa: `vendor/bin/pest Modules/Tenant/tests --group=<ID>`.

| Operazione | Contratto | Classe | Invarianti | Copertura | Comando di esempio |
|---|---|---|---|---|---|
| GetTenantNameAction | [get-tenant-name-action](get-tenant-name-action.md) | `Modules\Tenant\Actions\GetTenantNameAction` | TENANT-NAME-INV-1..5 | dimostrate 0/5 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-NAME-INV-1` |
| GetTenantFilePathAction | [get-tenant-file-path-action](get-tenant-file-path-action.md) | `Modules\Tenant\Actions\Config\GetTenantFilePathAction` | TENANT-FILE-PATH-INV-1..3 | dimostrate 3/3 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-FILE-PATH-INV-1` |
| SaveTenantConfigAction | [save-tenant-config-action](save-tenant-config-action.md) | `Modules\Tenant\Actions\Config\SaveTenantConfigAction` | TENANT-CONFIG-SAVE-INV-1..4 | dimostrate 3/4 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-CONFIG-SAVE-INV-1` |
| CreateJsonFileByRecordAction | [create-json-file-by-record-action](create-json-file-by-record-action.md) | `Modules\Tenant\Actions\Json\CreateJsonFileByRecordAction` | TENANT-JSON-CREATE-INV-1..3 | dimostrate 2/3 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-JSON-CREATE-INV-1` |
| UpdateJsonFileByRecordAction | [update-json-file-by-record-action](update-json-file-by-record-action.md) | `Modules\Tenant\Actions\Json\UpdateJsonFileByRecordAction` | TENANT-JSON-UPDATE-INV-1..4 | dimostrate 0/4 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-JSON-UPDATE-INV-1` |
| DeleteJsonFileByRecordAction | [delete-json-file-by-record-action](delete-json-file-by-record-action.md) | `Modules\Tenant\Actions\Json\DeleteJsonFileByRecordAction` | TENANT-JSON-DELETE-INV-1..3 | dimostrate 0/3 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-JSON-DELETE-INV-1` |
| GetEnteDataAction | [get-ente-data-action](get-ente-data-action.md) | `Modules\Tenant\Actions\Ente\GetEnteDataAction` | TENANT-ENTE-INV-1..6 | dimostrate 0/6 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-ENTE-INV-1` |
| GetTenantConfigValueAction | [get-tenant-config-value-action](get-tenant-config-value-action.md) | `Modules\Tenant\Actions\Config\GetTenantConfigValueAction` | TENANT-CONFIG-VALUE-INV-1..4 | dimostrate 0/4 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-CONFIG-VALUE-INV-1` |
| GetTenantModelClassAction | [get-tenant-model-class-action](get-tenant-model-class-action.md) | `Modules\Tenant\Actions\Models\GetTenantModelClassAction` | TENANT-MODEL-CLASS-INV-1..5 | dimostrate 0/5 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-MODEL-CLASS-INV-1` |
| GetTenantModelInstanceAction | [get-tenant-model-instance-action](get-tenant-model-instance-action.md) | `Modules\Tenant\Actions\Models\GetTenantModelInstanceAction` | TENANT-MODEL-INST-INV-1..2 | dimostrate 0/2 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-MODEL-INST-INV-1` |
| GetTenantConfigArrayAction | [get-tenant-config-array-action](get-tenant-config-array-action.md) | `Modules\Tenant\Actions\Config\GetTenantConfigArrayAction` | TENANT-CFG-ARR-INV-1..3 | dimostrate 0/3 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-CFG-ARR-INV-1` |
| GetTenantConfigNamesAction | [get-tenant-config-names-action](get-tenant-config-names-action.md) | `Modules\Tenant\Actions\Config\GetTenantConfigNamesAction` | TENANT-CFG-NAMES-INV-1..2 | dimostrate 0/2 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-CFG-NAMES-INV-1` |
| GetTenantConfigPathAction | [get-tenant-config-path-action](get-tenant-config-path-action.md) | `Modules\Tenant\Actions\Config\GetTenantConfigPathAction` | TENANT-CFG-PATH-INV-1..2 | dimostrate 0/2 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-CFG-PATH-INV-1` |
| GetTenantModulesAction | [get-tenant-modules-action](get-tenant-modules-action.md) | `Modules\Tenant\Actions\Modules\GetTenantModulesAction` | TENANT-MODULES-INV-1..2 | dimostrate 0/2 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-MODULES-INV-1` |
| GetDomainsArrayAction | [get-domains-array-action](get-domains-array-action.md) | `Modules\Tenant\Actions\Domains\GetDomainsArrayAction` | TENANT-DOMAINS-INV-1..3 | dimostrate 0/3 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-DOMAINS-INV-1` |
| GetLocalizedMarkdownPathAction | [get-localized-markdown-path-action](get-localized-markdown-path-action.md) | `Modules\Tenant\Actions\Markdown\GetLocalizedMarkdownPathAction` | TENANT-MD-INV-1..4 | dimostrate 0/4 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-MD-INV-1` |
| TranslateTenantKeyAction | [translate-tenant-key-action](translate-tenant-key-action.md) | `Modules\Tenant\Actions\Translations\TranslateTenantKeyAction` | TENANT-TRANS-INV-1..3 | dimostrate 0/3 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-TRANS-INV-1` |
| FilterConfigStringKeysAction | [filter-config-string-keys-action](filter-config-string-keys-action.md) | `Modules\Tenant\Actions\Config\FilterConfigStringKeysAction` | TENANT-FILTER-INV-1..3 | dimostrate 0/3 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-FILTER-INV-1` |
| MergeRecursiveStringKeyConfigAction | [merge-recursive-string-key-config-action](merge-recursive-string-key-config-action.md) | `Modules\Tenant\Actions\Config\MergeRecursiveStringKeyConfigAction` | TENANT-MERGE-INV-1..2 | dimostrate 0/2 | `vendor/bin/pest Modules/Tenant/tests --group=TENANT-MERGE-INV-1` |

Totale: 63 invarianti, 8 dimostrate da un test con group.
