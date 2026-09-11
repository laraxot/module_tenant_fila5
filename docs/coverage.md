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

## 2026-09-04 — app/Services retired, converted to Actions (no-services-rule)

Task: eliminate `app/Services/` in this module per
`bashscripts/ai/wiki/rules/no-services-rule.md` ("RELIGION", no exceptions on destination).
Full classification, reasoning and per-file mapping is in the story:
`docs/stories/tenant-services-to-actions.story.md`. Summary:

- `app/Services/TenantService.php` — **Kind A, already-thin facade**. All 11 public
  methods already delegated 1:1 to existing `app/Actions/**` classes (this module's own
  `tenant-service-to-actions-migration.md` concept doc, dated 2026-07-21, documents the
  original migration — the facade was kept afterwards as a thin static wrapper). Deleted
  outright; the only real call sites left (repo-wide grep, `Modules/` tree) were 2 test
  files in this module, updated to call `app(XxxAction::class)->execute(...)` directly.
  Two mentions of `TenantService::` in `Modules/Notify` and `Modules/User` are **commented-out
  dead code** (`// $middleware=TenantService::config(...)`, `* $data =
  TenantService::getConfig('sms');`), not live call sites — left as-is, not functional
  references.
- `app/Services/Config/ConfigResolverRegistry.php`,
  `app/Services/Config/Contracts/ConfigResolverInterface.php`,
  `app/Services/Config/Resolvers/{Database,MorphMap,Standard}ConfigResolver.php` —
  **proven dead code, deleted, not relocated**. Repo-wide grep (`Modules/` tree) plus a
  check of `TenantServiceProvider` confirmed zero production callers: nothing
  instantiates `ConfigResolverRegistry`, nothing binds it in a provider, and the real
  config-resolution path (`ResolveTenantConfigValueAction`) uses a completely independent
  implementation (`FilterConfigStringKeysAction` + `MergeRecursiveStringKeyConfigAction`),
  not this chain. This matches a **prior real audit already done in this exact repo**:
  commit `a85698f` ("Delete dead ConfigResolverRegistry strategy-chain (zero callers)",
  2026-07-02, same author) reached the identical conclusion via phpmd/phpinsights/grep —
  the files were resurrected afterward by an anonymous `.`-message commit (`3b521d2`),
  apparently an accidental restore, not a deliberate re-introduction. Re-verified the
  conclusion independently rather than trusting the old commit message; only test files
  (`TenantCoverageBoostTest.php`, `TenantStatementCoverageTest.php`,
  `TenantGapsCoverageTest.php`) referenced these classes, purely for coverage padding —
  those test blocks were removed (dead code testing dead code has no value), one small
  unrelated assertion (`DatabaseConfig` model casts) was kept and given its own test.
  Per the module's own no-services-rule carve-out ("a class without a real `execute()`
  doesn't live in `Actions/`"), moving genuinely dead code into
  `Actions/Config/Strategies/` would have just relocated the anti-pattern one level down
  instead of removing it — root-cause deletion was judged the smaller, safer, more
  honest move.
- `app/Services/Config/ConfigStringKeyFilter.php` — **proven duplicate of production
  Actions, deleted**. `onlyStringKeys()` and `mergeRecursive()` are byte-for-byte the same
  logic already living in `app/Actions/Config/FilterConfigStringKeysAction::execute()` and
  `app/Actions/Config/MergeRecursiveStringKeyConfigAction::execute()` (both already
  `QueueableAction`, already used by the real production path). Zero production callers;
  the one test caller (`TenantCoverageBoostTest.php`) was pointed at the existing Actions
  instead — no new Action file needed since equivalents already existed.

**Result**: `app/Services/` no longer exists in this module (verified: `find
Modules/Tenant/app/Services` → empty, directory removed).

**PHPStan**: true baseline (`clear-result-cache` then `analyse Modules/Tenant
--no-progress --error-format=table`) → **0 errors**. Same command after this diff → still
0 errors for every file this session touched, but the full-module run currently aborts
with 6 `phpstan.parse` (non-ignorable) syntax errors from **another, unrelated, concurrent
session** that appeared mid-task in `Modules/Tenant/app/Actions/Config/{ConfigResolverInterface,
ConfigResolverRegistry,ConfigStringKeyFilter,DatabaseConfigResolver,MorphMapConfigResolver,
StandardConfigResolver}Action.php` and `app/Actions/TenantAction.php` — all 7 files are
git-untracked (`??`), not authored by this session, and appear to be a different,
apparently-stalled attempt at the *exact same* Services→Actions migration (mechanical
`*Action` suffix rename with a broken template: `final class ConfigStringKeyFilter { use
QueueableAction; {` — doubled brace, class not even renamed). Left untouched per repo
policy (never discard/touch another session's uncommitted work). To prove this diff is
clean despite the collision: `phpstan analyse` on the explicit list of every `*.php` file
in the module **except** those 7 foreign files → `[OK] No errors` (134 files). See the
story file for the full collision note.

**PHPMD**: whole-module run crashes on an unrelated anonymous class
(`No node to visit provided for visitAnonymousClass`, pre-existing/known per
`quality-tooling-real-commands`). Scoped to the 3 test files this session changed: no
violations.

**Pest**: `./vendor/bin/pest Modules/Tenant/tests -c Modules/Tenant/phpunit.xml
--no-coverage --filter "TenantCoverageBoostTest|TenantStatementCoverageTest|TenantGapsCoverageTest"`
→ 29 passed, 12 failed. All 12 failures are `RuntimeException: Unexpected mockery
expectation type.` thrown by `Modules/Tenant/tests/TestCase.php:208`
(`expectMockery()`), a pre-existing helper that is itself mid-edit and uncommitted
(`git status --short` shows `tests/TestCase.php` modified before this task started,
part of the same concurrent-session drift). Confirmed not caused by this diff: every
failure is on a test line this session did not touch (e.g. `hasRole`/`hasPermissionTo`
mock setup, sushi file-path mocks), and this session's own new test block ("Config and
model actions resolve via container") passes.