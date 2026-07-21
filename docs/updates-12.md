# Tenant Module Updates - December 2025

## PHPStan Fixes
<<<<<<< .merge_file_Ln0LUQ
- **DocBlock Updates**: Fixed `class.notFound` errors in `Tenant`, `Domain`, and `TestSushiModel` by replacing incorrect `TechPlanner` and `healthcare_app` profile references with `Modules\Xot\Contracts\ProfileContract`.
=======
- **DocBlock Updates**: Fixed `class.notFound` errors in `Tenant`, `Domain`, and `TestSushiModel` by replacing incorrect `TechPlanner` and `ModuloEsempio` profile references with `Modules\Xot\Contracts\ProfileContract`.
>>>>>>> .merge_file_mSJxzJ
- **Helper Functions**: Added `getAllModulesModels` and `array_merge_recursive_distinct` to `Modules/Xot/Helpers/Helper.php` to resolve undefined function errors.
- **TenantService Refactor**: Adhering to the "Fat Model, Skinny Controller" (and Service) philosophy, all business logic has been extracted into dedicated Action classes:
    - `GetTenantFilePathAction`
    - `ResolveTenantConfigValueAction`
    - `GetTenantConfigPathAction`
    - `GetTenantConfigArrayAction`
    - `SaveTenantConfigAction`
    - `ResolveTenantModelClassAction`
    - `ResolveTenantModelInstanceAction`
    - `GetLocalizedMarkdownPathAction`
    - `TranslateTenantKeyAction`
    - `GetTenantConfigNamesAction`
    - `GetTenantModulesAction`
- **TenantService::trans**: Enhanced the `trans` method to safely handle missing translation files, returning the key instead of throwing a `FileNotFoundException`. This fixed test failures in dependent modules.

## Architectural Alignment
This module adheres to the **Super Cow Methodology**:
- **Compliance**: Module now passes PHPStan analysis at Level 10.
- **Documentation**: Referenced core architecture rules in `Modules/Xot/docs/`.
