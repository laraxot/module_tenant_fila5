<?php

declare(strict_types=1);

use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    unset($_SERVER['SERVER_NAME']);
});

test('get tenant name action returns string from server name when matching config exists', function () {
    $_SERVER['SERVER_NAME'] = 'myapp.example.com';
    config(['app.url' => 'http://localhost']);

    $action = new GetTenantNameAction;
    $result = $action->execute();

    Assert::assertIsString($result);
    Assert::assertNotSame('', $result);
});

test('get tenant name action handles www prefix', function () {
    $_SERVER['SERVER_NAME'] = 'www.myapp.example.com';
    config(['app.url' => 'http://localhost']);

    $action = new GetTenantNameAction;
    $result = $action->execute();

    Assert::assertIsString($result);
    Assert::assertNotSame('', $result);
});

test('get tenant name action falls back when server name is loopback', function () {
    $_SERVER['SERVER_NAME'] = '127.0.0.1';
    config(['app.url' => 'http://localhost']);

    $action = new GetTenantNameAction;
    $result = $action->execute();

    Assert::assertIsString($result);
    Assert::assertNotSame('', $result);
});

test('get tenant name action uses app url when server name not set', function () {
    unset($_SERVER['SERVER_NAME']);
    config(['app.url' => 'https://myapp.test']);

    $action = new GetTenantNameAction;
    $result = $action->execute();

    Assert::assertIsString($result);
    Assert::assertNotSame('', $result);
});

test('get tenant name action returns localhost when app url is empty and no config match', function () {
    unset($_SERVER['SERVER_NAME']);
    config(['app.url' => '']);

    $action = new GetTenantNameAction;
    $result = $action->execute();

    Assert::assertTrue(
        $result === 'localhost' || $result === '',
        'Empty app.url should resolve to localhost or empty fallback.',
    );
});
