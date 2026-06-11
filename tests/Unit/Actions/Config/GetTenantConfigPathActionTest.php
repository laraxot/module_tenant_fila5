<?php

declare(strict_types=1);

use Modules\Tenant\Actions\Config\GetTenantConfigPathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('gets tenant config path', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, function ($mock): void {
        $mock->allows([
            'execute' => 'test-tenant',
        ]);
    });

    $action = app(GetTenantConfigPathAction::class);
    $result = $action->execute('database');

    Assert::assertSame('test-tenant.database', $result);
});

test('gets tenant config path with forward slashes replaced', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, function ($mock): void {
        $mock->allows([
            'execute' => 'tenants/test',
        ]);
    });

    $action = app(GetTenantConfigPathAction::class);
    $result = $action->execute('app');

    Assert::assertSame('tenants.test.app', $result);
});
