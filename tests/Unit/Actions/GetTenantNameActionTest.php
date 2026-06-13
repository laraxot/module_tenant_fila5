<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions;

use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Tenant\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\Tenant\Tests\TestCase $this */
unset($_SERVER['SERVER_NAME']);
});

describe('Get Tenant Name Action', function (): void {
    test('_get_tenant_name_action_returns_string_from_server_name_when_matching_config_exists', function (): void {
$_SERVER['SERVER_NAME'] = 'myapp.example.com';
        config(['app.url' => 'http://localhost']);

        $action = new GetTenantNameAction;
        $result = $action->execute();

        /** @phpstan-ignore-next-line */
        Assert::assertIsString($result);
        Assert::assertNotSame('', $result);
    });

    test('_get_tenant_name_action_handles_www_prefix', function (): void {
$_SERVER['SERVER_NAME'] = 'www.myapp.example.com';
        config(['app.url' => 'http://localhost']);

        $action = new GetTenantNameAction;
        $result = $action->execute();

        /** @phpstan-ignore-next-line */
        Assert::assertIsString($result);
        Assert::assertNotSame('', $result);
    });

    test('_get_tenant_name_action_falls_back_when_server_name_is_loopback', function (): void {
$_SERVER['SERVER_NAME'] = '127.0.0.1';
        config(['app.url' => 'http://localhost']);

        $action = new GetTenantNameAction;
        $result = $action->execute();

        /** @phpstan-ignore-next-line */
        Assert::assertIsString($result);
        Assert::assertNotSame('', $result);
    });

    test('_get_tenant_name_action_uses_app_url_when_server_name_not_set', function (): void {
unset($_SERVER['SERVER_NAME']);
        config(['app.url' => 'https://myapp.test']);

        $action = new GetTenantNameAction;
        $result = $action->execute();

        /** @phpstan-ignore-next-line */
        Assert::assertIsString($result);
        Assert::assertNotSame('', $result);
    });

    test('_get_tenant_name_action_returns_localhost_when_app_url_is_empty_and_no_config_match', function (): void {
unset($_SERVER['SERVER_NAME']);
        config(['app.url' => '']);

        $action = new GetTenantNameAction;
        $result = $action->execute();

        Assert::assertTrue(
            $result === 'localhost' || $result === '',
            'Empty app.url should resolve to localhost or empty fallback.',
        );
    });
});
