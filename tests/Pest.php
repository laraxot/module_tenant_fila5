<?php

declare(strict_types=1);

use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\Tenant\Models\Tenant;

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
    return TenantFactory::new()->createOne($attributes);
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
