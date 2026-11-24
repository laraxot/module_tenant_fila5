---
title: "Audit approfondito modulo Tenant"
type: audit
status: review
updated: 2026-11-16
module: Tenant
qmd: "audit approfondito Tenant inventario PHPStan Pest policy Filament Actions"
---

# Audit approfondito — Tenant

## Metodo

Source-first (2026-11-16): inventario filesystem, `rg` su policy/marker/label,
lettura purpose esistente, PHPStan globale Modules già a 0 errori. Nessuna UI
inventata. Pest dichiarato solo se eseguito.

## Inventario misurato

| Area | Conteggio |
|---|---:|
| PHP in `app/` | 56 |
| Test PHP | 65 |
| Models (`app/Models/*.php`) | 10 |
| Policy files (approx) | 4 |
| Resource Filament | 1 |
| Actions | 19 |
| Services | 0 |
| Migration | 3 |
| Lang IT files | 14 |
| Marker conflitto | 0 |
| Occorrenze `return true` in Policy | 2 |
| Ratio test/app | 1.16 |

## Scopo (da docs esistenti / codice)

## Lo scopo in una frase **Tenant permette a una sola installazione di servire piu' enti senza che nessuno veda i dati dell'altro, e di farlo cambiando configurazione invece che codice.**

## Finding preliminari (da inventario)

- Nessun finding automatico critico dall'inventario; completare review sicurezza/runtime con story dedicate.

## Finding approfonditi (codice)

- **P0** Isolamento DB non automatico: `TenantSetting` senza global scope; test ammette leak cross-tenant.
- **P1** Isolamento reale = path filesystem (`GetTenantFilePathAction`), non row-level.
- **P2** Doppione modello Tenant in User.

## Gate

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Tenant
# Pest solo fuori da 10.100.200.15 e con DB testing raggiungibile
./vendor/bin/pest Modules/Tenant/tests --no-coverage
```

PHPStan `Modules` (2026-11-16): **0 errori** sul tree completo.

## Piano

Vedi [piano-miglioramento.md](../piano-miglioramento.md).

## Riferimenti

- [audit.md](../audit.md)
- [ECC](../../ecc/tenant-ecc-audit.md)
- [Story](../stories/module-bmad-audit.story.md)
