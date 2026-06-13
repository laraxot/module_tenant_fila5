<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Modules\Tenant\Actions\Config\GetTenantConfigPathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Tenant\Tests\TestCase::class);

describe('Get Tenant Config Path Action', function (): void {
    test('_gets_tenant_config_path', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
$this->mockService(GetTenantNameAction::class, function ($mock): void {
            $mock->allows([
                'execute' => 'test-tenant',
            ]);
        });

        $action = app(GetTenantConfigPathAction::class);
        $result = $action->execute('database');

        Assert::assertSame('test-tenant.database', $result);
    });

    test('_gets_tenant_config_path_with_forward_slashes_replaced', function (): void {
$this->mockService(GetTenantNameAction::class, function ($mock): void {
            $mock->allows([
                'execute' => 'tenants/test',
            ]);
        });

        $action = app(GetTenantConfigPathAction::class);
        $result = $action->execute('app');

        Assert::assertSame('tenants.test.app', $result);
    });
});
