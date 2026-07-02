# Ponytail audit — Tenant Config resolver chain (2026-07-02)

**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)

## Finding

`Modules/Tenant/app/Services/Config/` contained a strategy-chain implementation
for config value resolution:

- `ConfigResolverRegistry.php`
- `Resolvers/StandardConfigResolver.php`
- `Resolvers/DatabaseConfigResolver.php`
- `Resolvers/MorphMapConfigResolver.php`
- `Contracts/ConfigResolverInterface.php`

Investigation showed this registry/strategy chain has **zero call sites**
anywhere in the monorepo: it is never instantiated, never bound in a service
provider or container, never referenced from a test, and the actual
production config-resolution path is `ResolveTenantConfigValueAction`
(`Modules/Tenant/app/Actions/Config/ResolveTenantConfigValueAction.php`),
which does not touch the registry or any of the resolver classes.

## Decision: deleted, not collapsed

The original plan was to collapse the chain into something simpler. On
inspection this was the wrong move — there is nothing to collapse, because
nothing calls it. Simplifying dead code still leaves dead code. The correct
ponytail move here is deletion:

- Does this need to exist? No — the real resolution path is
  `ResolveTenantConfigValueAction`, which already worked without this class
  hierarchy.
- Zero callers, zero DI bindings, zero tests exercising it.

## Action taken

Deleted the 5 dead files:

- `app/Services/Config/ConfigResolverRegistry.php`
- `app/Services/Config/Resolvers/StandardConfigResolver.php`
- `app/Services/Config/Resolvers/DatabaseConfigResolver.php`
- `app/Services/Config/Resolvers/MorphMapConfigResolver.php`
- `app/Services/Config/Contracts/ConfigResolverInterface.php`

Kept `app/Services/Config/ConfigStringKeyFilter.php` — it is a small,
independent utility, unrelated to the dead resolver chain.

## Verification

- `grep` across the whole monorepo (not just `Modules/Tenant`) for all 5
  deleted class names: zero remaining references.
- `phpmd.phar` against `Modules/Tenant/app/Services/Config`: no violations.
- `php artisan insights` against the same directory: Code 100%, Complexity
  100%, Architecture 93.8%, Style 97.6% — the only remaining notes are minor
  pre-existing style nits on the kept `ConfigStringKeyFilter.php`, unrelated
  to this deletion.
- `phpstan analyse Modules/Tenant` could not run to completion: the
  monorepo's app bootstrap currently fails on an unrelated missing interface
  (`Modules\Xot\Contracts\ModelContract`, referenced from
  `Modules/Quaeris/app/Models/QuestionChart.php`). This is a pre-existing
  environment issue, reproducible before this change, and unrelated to the
  Tenant Config deletion.
- `git status` after deletion showed only the 5 intended file deletions —
  no collateral changes.

## Collegamenti

- [wiki/concepts/ponytail-audit.md](./wiki/concepts/ponytail-audit.md)
- [ponytail-audit-over-engineering.md](./ponytail-audit-over-engineering.md)
