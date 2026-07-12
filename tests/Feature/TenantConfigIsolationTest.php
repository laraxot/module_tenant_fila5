<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Feature;

use InvalidArgumentException;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('isolates tenant file paths per tenant context', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'tenant-a']);
    });

    $pathA = app(GetTenantFilePathAction::class)->execute('settings.json');

    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'tenant-b']);
    });

    $pathB = app(GetTenantFilePathAction::class)->execute('settings.json');

    Assert::assertStringContainsString('tenant-a', $pathA);
    Assert::assertStringContainsString('tenant-b', $pathB);
    Assert::assertNotSame($pathA, $pathB);
});

it('rejects path traversal in tenant filename', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'tenant-a']);
    });

    $this->expectException(InvalidArgumentException::class);

    app(GetTenantFilePathAction::class)->execute('../../etc/passwd');
});

it('rejects malicious server name with path traversal', function (): void {
    $_SERVER['SERVER_NAME'] = '../../evil.com';

    $action = new GetTenantNameAction();
    $result = $action->execute();

    Assert::assertSame('localhost', $result);
});
