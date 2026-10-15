<?php

declare(strict_types=1);

namespace Tests\Modules\Tenant\Unit\Actions\Config;

use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Tests\Modules\Tenant\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('gets tenant file path', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'test-tenant']);
    });

    $result = app(GetTenantFilePathAction::class)->execute('database.php');

    $expected = base_path('config/test-tenant/database.php');
    $expected = str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $expected);

    Assert::assertSame($expected, $result);
});
