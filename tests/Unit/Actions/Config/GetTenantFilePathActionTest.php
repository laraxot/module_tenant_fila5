<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Tenant\Tests\TestCase::class);

describe('Get Tenant File Path Action', function (): void {
    test('_gets_tenant_file_path', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
$this->mockService(GetTenantNameAction::class, function ($mock): void {
            $mock->allows([
                'execute' => 'test-tenant',
            ]);
        });

        $action = app(GetTenantFilePathAction::class);
        $result = $action->execute('database.php');

        $expected = base_path('config/test-tenant/database.php');
        $expected = str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $expected);

        Assert::assertSame($expected, $result);
    });
});
