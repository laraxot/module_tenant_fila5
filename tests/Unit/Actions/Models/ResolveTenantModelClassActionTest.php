<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Models;

<<<<<<< .merge_file_Zw0NA8
<<<<<<< HEAD
use Mockery;
=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_BPnigZ
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelClassAction;
<<<<<<< .merge_file_Zw0NA8
<<<<<<< HEAD
use Modules\Tenant\Models\Tenant;
=======
>>>>>>> .merge_file_BPnigZ
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Nwidart\Modules\Facades\Module;
<<<<<<< .merge_file_Zw0NA8
use Nwidart\Modules\Laravel\Module as LaravelModule;
=======
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Nwidart\Modules\Facades\Module;
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_BPnigZ
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('resolves tenant model class from config', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'Modules\Test\Models\TestModel']);
    });

    $result = app(ResolveTenantModelClassAction::class)->execute('test_model');

    Assert::assertSame('Modules\Test\Models\TestModel', $result);
});

it('resolves tenant model class by scanning modules if not in config', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => null]);
    });

<<<<<<< .merge_file_Zw0NA8
<<<<<<< HEAD
    $module = Mockery::mock(LaravelModule::class);
    TestCase::expectMockery($module, 'getName')->andReturn('Meetup');
=======
    $module = new class() {
=======
    $module = new class
    {
>>>>>>> .merge_file_BPnigZ
        public function getName(): string
        {
            return 'Meetup';
        }
    };
<<<<<<< .merge_file_Zw0NA8
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_BPnigZ

    Module::shouldReceive('allEnabled')->andReturn([$module]);

    $this->mockService(GetAllModelsByModuleNameAction::class, static function (MockInterface $mock): void {
<<<<<<< .merge_file_Zw0NA8
<<<<<<< HEAD
        $mock->allows(['execute' => ['tenant' => Tenant::class]]);
=======
        $mock->allows(['execute' => ['event' => 'Modules\Meetup\Models\Event']]);
>>>>>>> 1ad0554 (.)
=======
        $mock->allows(['execute' => ['event' => 'Modules\Meetup\Models\Event']]);
>>>>>>> .merge_file_BPnigZ
    });

    $this->mockService(SaveTenantConfigAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => true]);
    });

<<<<<<< .merge_file_Zw0NA8
<<<<<<< HEAD
    $result = app(ResolveTenantModelClassAction::class)->execute('tenant');

    Assert::assertSame(Tenant::class, $result);
=======
    $result = app(ResolveTenantModelClassAction::class)->execute('event');

    Assert::assertSame('Modules\Meetup\Models\Event', $result);
>>>>>>> 1ad0554 (.)
=======
    $result = app(ResolveTenantModelClassAction::class)->execute('event');

    Assert::assertSame('Modules\Meetup\Models\Event', $result);
>>>>>>> .merge_file_BPnigZ
});

it('throws exception for unknown model', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => null]);
    });

    Module::shouldReceive('allEnabled')->andReturn([]);

<<<<<<< .merge_file_Zw0NA8
<<<<<<< HEAD
    XotBasePest::assertThrows(
=======
    assertTenantThrows(
>>>>>>> 1ad0554 (.)
=======
    assertTenantThrows(
>>>>>>> .merge_file_BPnigZ
        fn (): string => app(ResolveTenantModelClassAction::class)->execute('unknown_model'),
        \Exception::class,
    );
});
