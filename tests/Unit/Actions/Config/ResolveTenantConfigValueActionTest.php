<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Exception;
use Illuminate\Support\Facades\Config;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Tenant\Tests\TestCase::class);

describe('Resolve Tenant Config Value Action', function (): void {
    test('_resolves_tenant_config_value_by_merging_with_tenant_overrides', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
$this->mockService(GetTenantNameAction::class, function ($mock): void {
            $mock->allows([
                'execute' => 'test-tenant',
            ]);
        });

        Config::set('app.name', 'Base App');
        Config::set('app.timezone', 'UTC');
        Config::set('test-tenant.app', [
            'name' => 'Tenant App',
        ]);

        $action = app(ResolveTenantConfigValueAction::class);

        $result = $action->execute('app.name');
        Assert::assertSame('Tenant App', $result);

        $result = $action->execute('app.timezone');
        Assert::assertSame('UTC', $result);
    });

    test('_throws_exception_for_empty_config_key', function (): void {
$this->expectAppException(Exception::class);
        $action = app(ResolveTenantConfigValueAction::class);
        $action->execute('');
    });

    test('_returns_default_value_if_config_not_found', function (): void {
$this->mockService(GetTenantNameAction::class, function ($mock): void {
            $mock->allows([
                'execute' => 'test-tenant',
            ]);
        });

        $action = app(ResolveTenantConfigValueAction::class);
        $result = $action->execute('nonexistent.key', 'default');

        Assert::assertSame('default', $result);
    });
});
