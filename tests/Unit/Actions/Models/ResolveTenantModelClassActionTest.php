<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Models;

use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelClassAction;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

<<<<<<< HEAD
it('resolves tenant model class from config', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'Modules\Test\Models\TestModel']);
    });
=======
it('resolves tenant model class from config', function(): void {
    $this->mock(ResolveTenantConfigValueAction::class)
        ->shouldReceive('execute')
        ->with('morph_map.test_model')
        ->andReturn('Modules\Test\Models\TestModel');
>>>>>>> provtv/dev

    $result = app(ResolveTenantModelClassAction::class)->execute('test_model');

    Assert::assertSame('Modules\Test\Models\TestModel', $result);
});

<<<<<<< HEAD
it('resolves tenant model class by scanning modules if not in config', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => null]);
    });
=======
it('resolves tenant model class by scanning modules if not in config', function(): void {
    $this->mock(ResolveTenantConfigValueAction::class)
        ->shouldReceive('execute')
        ->with('morph_map.event')
        ->andReturn(null);
>>>>>>> provtv/dev

    $module = new class
    {
        public function getName(): string
        {
            return 'Meetup';
        }
    };

    Module::shouldReceive('allEnabled')->andReturn([$module]);

    $this->mockService(GetAllModelsByModuleNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => ['event' => 'Modules\Meetup\Models\Event']]);
    });

    $this->mockService(SaveTenantConfigAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => true]);
    });

    $result = app(ResolveTenantModelClassAction::class)->execute('event');

    Assert::assertSame('Modules\Meetup\Models\Event', $result);
});

<<<<<<< HEAD
it('throws exception for unknown model', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => null]);
    });
=======
it('throws exception for unknown model', function(): void {
    $this->mock(ResolveTenantConfigValueAction::class)
        ->shouldReceive('execute')
        ->andReturn(null);
>>>>>>> provtv/dev

    Module::shouldReceive('allEnabled')->andReturn([]);

    assertTenantThrows(
        fn (): string => app(ResolveTenantModelClassAction::class)->execute('unknown_model'),
        \Exception::class,
    );
});
