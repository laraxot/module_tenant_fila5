<?php

declare(strict_types=1);

use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\Tenant\Models\Tenant;
use PHPUnit\Framework\Assert;

/*
 * Bootstrap Pest — modulo Tenant.
 * Ogni file test dichiara uses(Modules\Tenant\Tests\TestCase::class).
 * Vietato pest()->extend() / expect()->extend() (PHPStan method.internalClass).
 */

/**
 * @param array<string, mixed> $attributes
 */
function createTenant(array $attributes = []): Tenant
{
    $tenant = TenantFactory::new()->createOne($attributes);
    if (! $tenant instanceof Tenant) {
        throw new RuntimeException('Expected Tenant model from factory');
    }

    return $tenant;
}

/**
 * @param array<string, mixed> $attributes
 */
function makeTenant(array $attributes = []): Tenant
{
    $tenant = TenantFactory::new()->make($attributes);
    if (! $tenant instanceof Tenant) {
        throw new RuntimeException('Expected Tenant model from factory');
    }

    return $tenant;
}

/**
 * @param  array<int|string, array<string, mixed>>  $rows
 * @return array<string, mixed>
 */
function sushiRowById(array $rows, int $id): array
{
    foreach ($rows as $row) {
        if ((int) ($row['id'] ?? 0) === $id) {
            return $row;
        }
    }

    Assert::fail(sprintf('No sushi row found with id %d', $id));
}
