<?php

declare(strict_types=1);
<<<<<<< HEAD
/*
 * Bootstrap Pest — modulo Tenant.
 *
 * Questo file NON viene caricato. `Pest\Bootstrappers\BootFiles` legge `Pest.php`,
 * `Helpers.php` ed `Expectations.php` da un solo percorso per run — quello della root —
 * quindi ogni funzione dichiarata qui è codice morto e i test che la chiamano falliscono
 * con `Call to undefined function`.
 *
 * Regole, non negoziabili:
 * - zero funzioni libere qui dentro (`grep -c '^function ' ` deve dare 0);
 * - helper condivisi: metodi statici su `Modules\Xot\Tests\XotBasePest` (autoload PSR-4,
 *   niente `require_once`);
 * - helper di dominio: metodi statici su `Modules\Tenant\Tests\TestCase`;
 * - ogni file di test dichiara `uses(\Modules\Tenant\Tests\TestCase::class)` in testa —
 *   un `uses()->in(...)` scritto qui non verrebbe applicato;
 * - `pest()->extend(TestCase::class)->in(...)` e' la forma consigliata (il divieto
 *   storico per `method.internalClass` e' decaduto con pest-plugin-phpstan, story
 *   XOT-5.41); vincolo XOR con gli `uses()` per-file (`TestCaseAlreadyInUse`):
 *   migrare per directory, non mescolare;
 * - vietata la cartella `tests/Support/` (ADR-002).
 */
=======

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Tenant;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;
use function Safe\json_decode;
use Webmozart\Assert\Assert as WebmozartAssert;

/*
 * Bootstrap Pest — modulo Tenant.
 * Ogni file test dichiara uses(\Modules\Tenant\Tests\TestCase::class).
 * Vietato pest()->extend() e expect()->extend() qui (PHPStan method.internalClass).
 */

/**
 * @param  array<array-key, mixed>  $rows
 *
 * @return array<string, mixed>
 */
function sushiRowById(array $rows, int|string $id): array
{
    foreach ($rows as $row) {
        if (! is_array($row)) {
            continue;
        }

        $rowId = $row['id'] ?? null;
        if ($rowId === $id || (is_numeric($rowId) && SafeIntCastAction::cast($rowId) === SafeIntCastAction::cast($id))) {
            /** @var array<string, mixed> $row */
            return $row;
        }
    }

    Assert::fail(sprintf('Row with id [%s] not found.', SafeStringCastAction::cast($id)));
}

/**
 * @return array<string, mixed>
 */
function assertTenantArray(mixed $value): array
{
    Assert::assertIsArray($value);

    /** @var array<string, mixed> $value */
    return $value;
}

/**
 * @param  class-string<\Throwable>  $exceptionClass
 */
function assertTenantThrows(callable $callback, string $exceptionClass, ?string $messageContains = null): void
{
    try {
        $callback();
    } catch (\Throwable $exception) {
        Assert::assertInstanceOf($exceptionClass, $exception);
        if ($messageContains !== null) {
            Assert::assertStringContainsString($messageContains, $exception->getMessage());
        }

        return;
    }

    Assert::fail(sprintf('Expected exception %s was not thrown.', $exceptionClass));
}

/**
 * @template T of Model
 *
 * @param  T  $model
 * @param  class-string<T>  $class
 *
 * @return T
 */
function assertFreshModel(Model $model, string $class)
{
    $fresh = $model->fresh();
    Assert::assertInstanceOf($class, $fresh);

    return $fresh;
}

/** @param array<string, mixed> $attributes */
function createTenant(array $attributes = []): Tenant
{
    /** @var \Modules\Tenant\Database\Factories\TenantFactory $factory */
    $factory = Tenant::factory();
    $tenant = $factory->create($attributes);
    WebmozartAssert::isInstanceOf($tenant, Tenant::class);

    return $tenant;
}

/** @param array<string, mixed> $attributes */
function makeTenant(array $attributes = []): Tenant
{
    /** @var \Modules\Tenant\Database\Factories\TenantFactory $factory */
    $factory = Tenant::factory();
    $tenant = $factory->make($attributes);
    WebmozartAssert::isInstanceOf($tenant, Tenant::class);

    return $tenant;
}

/**
 * @return array<int, array<string, mixed>>
 */
function decodeTenantJsonFile(string $path): array
{
    $content = \Illuminate\Support\Facades\File::get($path);
    $decoded = json_decode($content, true);
    Assert::assertIsArray($decoded);

    /** @var array<int, array<string, mixed>> $decoded */
    return $decoded;
}
>>>>>>> 1ad0554 (.)
