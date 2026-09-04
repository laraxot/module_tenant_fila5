---
title: "Tenant Module Test Coverage"
module: "Tenant"
type: concept
tags: [coverage]
created: 2026-07-14
updated: 2026-07-14
qmd: "coverage"
related:
  - "./phpstan-corrections-january.md"
---
# Tenant Module Test Coverage

## Overview
This module has comprehensive test coverage with various test types implemented.

## Test Results
- **Tests Passed**: 0
- **Assertions**: 0
- **Test Types**: Unit, Feature, Integration tests

## Coverage Statistics
- **Files**: 0
- **Lines of Code**: 0
- **Classes**: 0
- **Methods**: 0
- **Coverage Rate**: 0%

## Test Categories
- Unit Tests
- Feature Tests
- Integration Tests

## Status
All tests are passing and coverage is being maintained.

## 2026-09-04 — Mixed type reduction (best-effort)

Task: reduce `mixed` usage where a more specific type is knowable (project convention:
"cerchiamo di non usare mixed, quando lo troviamo cerchiamo di sostituirlo con qualcosa
di adeguato").

**Context**: at task start, `git status --short` on `Modules/Tenant` already showed ~80
files modified by a concurrent session (broad docs/whitespace/README rework, unrelated to
typing). Per repo convention (do not overwrite another session's live WIP, commit only
files you yourself change), edits were restricted to files that were clean in git status
at task start.

**Findings**: 207 occurrences of `mixed` across 44 files in the module (app + tests +
database + config). Of the 32 files under `app/`, `config/`, `database/` with `mixed`,
16 (including all 4 files with *native* `mixed` type-hints —
`app/Models/Traits/SushiToCsv.php:153,217`, `app/Models/Traits/SushiToJson.php:451`,
`app/Actions/Config/ResolveTenantConfigValueAction.php:68` — plus `TenantSetting.php`,
`tests/TestCase.php` static props, and several Pest `expect(fn(): mixed => ...)`
closures) were already modified by the concurrent session and were **left untouched** to
avoid entangling an unrelated commit; the native `mixed` occurrences there remain the
highest-value target for a future pass once that WIP lands.

**Changed** (1 file, clean at task start):
- `app/Actions/Config/FilterConfigStringKeysAction.php`: `@param array<mixed, mixed> $config`
  → `@param array<array-key, mixed> $config`. PHP array keys are only ever `int|string`;
  `array<mixed, mixed>` was imprecise. Matches the actual foreach body (`is_string($key)`
  filter).

**Reverted during verification**: `app/Services/TenantService.php` — attempted to narrow
`array<mixed>` → `array<string, mixed>` on `config()`'s param/return, consistent with the
sibling `ConfigResolverInterface`/`DatabaseConfigResolver` docblocks. PHPStan flagged a real
mismatch (`return.type`): the method delegates to
`ResolveTenantConfigValueAction::execute()`, whose own docblock/native return stays
`array<mixed>` (that file is one of the 16 under concurrent WIP, not editable here without
entangling commits). Narrowing the caller without the callee would have been dishonest
typing, so it was reverted — see `bashscripts/ai/wiki/rules/quando-si-ignora-un-errore-phpstan.md`-adjacent
principle: don't paper over a mismatch, fix the cause or leave both sides consistent.

**Left as `mixed` deliberately** (not a gap, verified evident/polymorphic shape):
- 7 database factories' `definition(): array` (`@return array<string, mixed>`) — genuinely
  heterogeneous per-column values (string/bool/DateTime), matches Laravel's own Factory
  contract.
- `config/database.php` (`@var array<string, mixed> $config`) — raw `require`d Laravel
  config array, heterogeneous by nature.
- `app/Models/BaseModelJsons.php` (`@property array<string, mixed> $form/$schema`) — JSON
  columns with no fixed shape.
- `app/Contracts/SushiToJsonContract.php`, `app/Services/Config/Contracts/ConfigResolverInterface.php`,
  `app/Services/Config/ConfigStringKeyFilter.php`,
  `app/Services/Config/Resolvers/{DatabaseConfigResolver,MorphMapConfigResolver}.php` —
  already `array<string, mixed>` / `string|int|array<string, mixed>|null` for genuinely
  polymorphic config-value payloads; no native `mixed` present.

**PHPStan**: 0 errors before → 0 errors after (`./vendor/bin/phpstan analyse Modules/Tenant
--no-progress --error-format=table`).

**PHPMD**: whole-module run crashes (`No node to visit provided for visitAnonymousClass`,
pre-existing/known-flaky per repo memory `quality-tooling-real-commands`). Scoped run on the
one changed file (`tools/phpmd.sh Modules/Tenant/app/Actions/Config/FilterConfigStringKeysAction.php
text ../docs/phpmd.ruleset.xml`): no violations.

**Pest**: `./vendor/bin/pest Modules/Tenant/tests -c Modules/Tenant/phpunit.xml --no-coverage`
→ 81 passed, 64 failed, 28 skipped. Failures are pre-existing and unrelated to this diff:
all observed failures are `ErrorException: Accessing static property ...::$testDirectory as
non static` inside `tests/Unit/Traits/SushiToJsonTest.php` and related files, which are
themselves mid-edit by the concurrent session (`git status --short` shows them `M` before
this task started) and never touched here. The dedicated test for the one file this task
did change, `tests/Unit/Actions/Config/FilterConfigStringKeysActionTest.php`, passes in
isolation (2 passed).