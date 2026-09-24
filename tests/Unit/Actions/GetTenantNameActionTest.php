<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions;

use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

<<<<<<< .merge_file_TJSSWh
<<<<<<< HEAD
use function Safe\mkdir;
use function Safe\rmdir;

=======
>>>>>>> .merge_file_gCcmD3
uses(TestCase::class);

test('get tenant name action returns correct tenant name from server name', function (): void {
    $_SERVER['SERVER_NAME'] = 'myapp.example.com';

    $result = app(GetTenantNameAction::class)->execute();
=======
uses(TestCase::class);

test('get tenant name action returns correct tenant name from server name', function (): void {
    $_SERVER['SERVER_NAME'] = 'myapp.example.com';

    $action = new GetTenantNameAction();
    $result = $action->execute();
>>>>>>> 1ad0554 (.)

    Assert::assertSame('com/example/myapp', $result);
});

test('get tenant name action handles www prefix correctly', function (): void {
<<<<<<< .merge_file_TJSSWh
<<<<<<< HEAD
    ensureTenantConfigDir('com/example/myapp');
    TestCase::setServerNameForTenantTest('www.myapp.example.com');
=======
    $_SERVER['SERVER_NAME'] = 'www.myapp.example.com';
>>>>>>> .merge_file_gCcmD3

    $result = app(GetTenantNameAction::class)->execute();
=======
    $_SERVER['SERVER_NAME'] = 'www.myapp.example.com';

    $action = new GetTenantNameAction();
    $result = $action->execute();
>>>>>>> 1ad0554 (.)

    Assert::assertSame('com/example/myapp', $result);
});

test('get tenant name action falls back to default when server name is localhost', function (): void {
<<<<<<< .merge_file_TJSSWh
<<<<<<< HEAD
    TestCase::setServerNameForTenantTest('127.0.0.1');
=======
    $_SERVER['SERVER_NAME'] = '127.0.0.1';
>>>>>>> .merge_file_gCcmD3

    $result = app(GetTenantNameAction::class)->execute();
=======
    $_SERVER['SERVER_NAME'] = '127.0.0.1';

    $action = new GetTenantNameAction();
    $result = $action->execute();
>>>>>>> 1ad0554 (.)

    Assert::assertSame('localhost', $result);
});

test('get tenant name action uses app url config when server name not set', function (): void {
<<<<<<< .merge_file_TJSSWh
<<<<<<< HEAD
    ensureTenantConfigDir('test/myapp');
    TestCase::setServerNameForTenantTest(null);
=======
    unset($_SERVER['SERVER_NAME']);
>>>>>>> .merge_file_gCcmD3
    config(['app.url' => 'https://myapp.test']);

    $result = app(GetTenantNameAction::class)->execute();
=======
    unset($_SERVER['SERVER_NAME']);
    config(['app.url' => 'https://myapp.test']);

    $action = new GetTenantNameAction();
    $result = $action->execute();
>>>>>>> 1ad0554 (.)

    Assert::assertSame('test/myapp', $result);
});

test('get tenant name action handles empty app url config', function (): void {
<<<<<<< .merge_file_TJSSWh
<<<<<<< HEAD
    TestCase::setServerNameForTenantTest(null);
=======
    unset($_SERVER['SERVER_NAME']);
>>>>>>> .merge_file_gCcmD3
    config(['app.url' => '']);

    $result = app(GetTenantNameAction::class)->execute();

<<<<<<< .merge_file_TJSSWh
    Assert::assertContains($result, ['', 'localhost']);
=======
    unset($_SERVER['SERVER_NAME']);
    config(['app.url' => '']);

    $action = new GetTenantNameAction();
    $result = $action->execute();

    Assert::assertSame('localhost', $result);
>>>>>>> 1ad0554 (.)
=======
    Assert::assertSame('localhost', $result);
>>>>>>> .merge_file_gCcmD3
});
