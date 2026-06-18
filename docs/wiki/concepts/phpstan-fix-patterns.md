---
title: "PHPStan fix patterns for Tenant module"
type: troubleshooting
tags: [phpstan, static-analysis, pest, mockery, tenant]
created: 2026-06-18
updated: 2026-06-18
qmd: "phpstan fix patterns tenant module mockService allows factory WebmozartAssert"
related:
  - ../../../../../docs/wiki/PHPSTAN-INDEX.md
  - ../../../Xot/docs/wiki/concepts/phpstan-pest-bridge-discipline.md
  - ../testing-rules.md
---

# PHPStan fix patterns — Tenant

## Stato (2026-06-18)

`./vendor/bin/phpstan analyse Modules/Tenant` → **0 errori** (da 655).

## Codice produzione

| Area | Fix |
|------|-----|
| Modelli Eloquent | `@return HasMany<User, $this>`, `@return BelongsTo<Tenant, $this>`, `@property array<string, mixed>` |
| `GetDomainsArrayAction` | Loop esplicito post-`collapse()`; `@var array<string, mixed>` su array annidati |
| `ConfigResolverInterface` / `TenantService` | `array<mixed>` allineato a `ResolveTenantConfigValueAction` |
| `config/database.php` | Delega a `config/database.php` root (no `env()` Larastan) |
| `config/modules.php` | Literal per sezione `composer` (no `env()`) |
| `TestSushiModel` | `@phpstan-use HasXotFactory<TestSushiModelFactory>` |

## Test — religione

**Non creare modelli/classi solo per far passare test obsoleti.** Preferire:

1. **Eliminare** test duplicati o che referenziano modelli inesistenti (`Audit`, `Setting`, `DatabaseConfig`, …).
2. **Correggere** test utili con pattern PHPStan-safe.

### Pattern Pest + PHPStan

| Anti-pattern | Fix |
|--------------|-----|
| `$this->mock()` in closure Pest | `$this->mockService()` da `XotBaseTestCase` |
| `$mock->shouldReceive()->andReturn()` | `$mock->allows(['execute' => $value])` |
| `->throws()` su `it()` (PHPStan vede `null`) | `assertTenantThrows()` in `tests/Pest.php` |
| `Tenant::factory()->create()` → `mixed` | `@var TenantFactory $factory` + `WebmozartAssert::isInstanceOf()` |
| `Tests\TestCase` (root Laravel) | `Modules\Tenant\Tests\TestCase` |
| `assertDatabaseHas()` protetto | `$this->assertDatabaseHasRow()` |

### Test rimossi (ridondanti / rotti)

- `tests/Unit/TenantModelsTest.php` — modelli fantasma
- `tests/Integration/*SushiToJson*` — duplicati, centinaia di errori
- `tests/Performance/SushiToJsonPerformanceTest.php`
- `tests/Unit/SushiToJsonTraitTest.php`, `tests/Unit/Traits/SushiToJsonTest.php`
- `tests/Unit/ApplicationPublicPathCoverageTest.php` — scope `App\Application`, non Tenant
- `tests/Unit/DomainModelTest.php` — duplicato di `DomainTest`

### Test mantenuti / riscritti

- `tests/Unit/SushiToJsonTraitPestTest.php` — 4 casi essenziali, path isolato in `testing`
- `tests/Feature/TenantBusinessLogicTest.php` — Pest + `createTenant()` + factory tipizzate

## Comandi

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Tenant
./tools/phpmd.sh Modules/Tenant/app text Modules/Tenant/phpmd.ruleset.xml
./tools/phpinsights.sh analyse Modules/Tenant/app --no-interaction
./vendor/bin/pest Modules/Tenant/tests
```
