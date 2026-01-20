# database population

## test sushi seeder update (2025-11-11)
- enforced `Factory` type safety in `TestSushiSeeder` using `Webmozart\Assert` to avoid PHPStan `method.nonObject` on `create()` and `count()`.
- each call to `TestSushiModel::factory()` is now validated (`Assert::isInstanceOf`) before invoking fluent methods.
- generic PHPDoc hints (`Factory<TestSushiModel>`) clarify return types for PHPStan level 10.
- additional random seeding for local/dev keeps the same behaviour but with explicit assertions.

## rationale
- prevents mixed factory instances when the generator is replaced/mocked.
- aligns Tenant seeding strategy with Laraxot "fix, don’t ignore" philosophy.
- keeps seeding limited to local/test environments (`app()->environment([...])`).

## related files
- `Modules/Tenant/database/seeders/TestSushiSeeder.php`
- `Modules/Tenant/Models/TestSushiModel.php`
