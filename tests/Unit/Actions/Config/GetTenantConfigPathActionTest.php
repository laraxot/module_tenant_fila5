<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Modules\Tenant\Actions\Config\GetTenantConfigPathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class GetTenantConfigPathActionTest extends TestCase
{
    public function test_gets_tenant_config_path(): void
    {
        $this->mockService(GetTenantNameAction::class, function ($mock): void {
            $mock->allows([
                'execute' => 'test-tenant',
            ]);
        });

        $action = app(GetTenantConfigPathAction::class);
        $result = $action->execute('database');

        Assert::assertSame('test-tenant.database', $result);
    }

    public function test_gets_tenant_config_path_with_forward_slashes_replaced(): void
    {
        $this->mockService(GetTenantNameAction::class, function ($mock): void {
            $mock->allows([
                'execute' => 'tenants/test',
            ]);
        });

        $action = app(GetTenantConfigPathAction::class);
        $result = $action->execute('app');

        Assert::assertSame('tenants.test.app', $result);
    }
}
