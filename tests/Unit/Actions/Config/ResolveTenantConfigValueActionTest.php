<?php

declare(strict_types=1);

use Exception;
use Illuminate\Support\Facades\Config;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('resolves tenant config value by merging with tenant overrides', function (): void {
    /** @var TestCase $this */
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

test('throws exception for empty config key', function (): void {
    /** @var TestCase $this */
    $this->expectAppException(Exception::class);
    $action = app(ResolveTenantConfigValueAction::class);
    $action->execute('');
});

test('returns default value if config not found', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, function ($mock): void {
        $mock->allows([
            'execute' => 'test-tenant',
        ]);
    });

    $action = app(ResolveTenantConfigValueAction::class);
    $result = $action->execute('nonexistent.key', 'default');

    Assert::assertSame('default', $result);
});
