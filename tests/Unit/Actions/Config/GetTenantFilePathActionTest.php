<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('gets tenant file path', function (): void {
<<<<<<< HEAD
   /** @var TestCase $this */
=======
    /** @var TestCase $this */
>>>>>>> laraxot/dev
    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'test-tenant']);
    });

    $result = app(GetTenantFilePathAction::class)->execute('database.php');

    $expected = base_path('config/test-tenant/database.php');
    $expected = str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $expected);

<<<<<<< HEAD
   Assert::assertSame($expected, $result);
=======
    Assert::assertSame($expected, $result);
>>>>>>> laraxot/dev
});
