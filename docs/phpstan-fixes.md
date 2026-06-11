---
title: "PHPStan fixes — modulo Tenant"
type: troubleshooting
module: Tenant
tags: [phpstan, tenant, pest, testing]
created: 2026-06-10
updated: 2026-06-10
qmd: "PHPStan Tenant module fixes STORY-309 bootstrap TestCase XotBase"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/338"
discussions: []
related:
  - ../../../../docs/stories/STORY-309-phpstan-tenant-zero-errors.md
  - ../../../../docs/wiki/memories/phpstan-bootstrap-xotbase-testcase-fix.md
---

# PHPStan — Tenant (STORY-309)

## Stato

- `Modules/Tenant/app`: **0 errori codice**
- `Modules/Tenant` totale: ~98 errori test (da ~986)

## Pattern

| Problema | Fix |
|----------|-----|
| `$this` mixed in Pest | `@var TestCase $this` + hook dentro `describe()` |
| `mockService()->shouldReceive()` | return `Mockery\MockInterface` o closure in `mockService()` |
| `->throws()` Pest | `$this->expectAppException()` su `TestCase` |
| Helper path Sushi | `sushiJsonPath()`, `sushiTestDirectory()` su `TestCase` |

## Script

```bash
cd laravel
php scripts/phpstan/fix-pest-tests.php Modules/Tenant/tests
php scripts/phpstan/inject-pest-this-var.php Modules/Tenant/tests
./vendor/bin/phpstan analyse Modules/Tenant
```

`phpstan.neon` — solo utente.
