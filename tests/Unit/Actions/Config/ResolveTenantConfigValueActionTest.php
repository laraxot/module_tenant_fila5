<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Illuminate\Support\Facades\Config;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
<<<<<<< .merge_file_nKbtfv
<<<<<<< HEAD
use Modules\Xot\Tests\XotBasePest;
=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_wjJCyZ
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('resolves tenant config value by merging with tenant overrides', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'test-tenant']);
    });

    Config::set('app.name', 'Base App');
    Config::set('app.timezone', 'UTC');
    Config::set('test-tenant.app', [
        'name' => 'Tenant App',
    ]);

    $action = app(ResolveTenantConfigValueAction::class);

    Assert::assertSame('Tenant App', $action->execute('app.name'));
    Assert::assertSame('UTC', $action->execute('app.timezone'));
});

it('throws exception for empty config key', function (): void {
<<<<<<< .merge_file_nKbtfv
<<<<<<< HEAD
    XotBasePest::assertThrows(
        fn (): float|int|string|array|null => app(ResolveTenantConfigValueAction::class)->execute(''),
=======
    assertTenantThrows(
        fn (): mixed => app(ResolveTenantConfigValueAction::class)->execute(''),
>>>>>>> 1ad0554 (.)
=======
    assertTenantThrows(
        fn (): mixed => app(ResolveTenantConfigValueAction::class)->execute(''),
>>>>>>> .merge_file_wjJCyZ
        \Exception::class,
    );
});

it('returns default value if config not found', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'test-tenant']);
    });

    $result = app(ResolveTenantConfigValueAction::class)->execute('nonexistent.key', 'default');

    Assert::assertSame('default', $result);
});
