<?php

declare(strict_types=1);

use Exception;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelClassAction;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('resolves tenant model class from config', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, function ($mock): void {
        $mock->allows([
            'execute' => static fn (string $key): ?string => $key === 'morph_map.test_model'
                ? 'Modules\Test\Models\TestModel'
                : null,
        ]);
    });

    $action = app(ResolveTenantModelClassAction::class);
    $result = $action->execute('test_model');

    Assert::assertSame('Modules\Test\Models\TestModel', $result);
});

test('resolves tenant model class by scanning modules if not in config', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, function ($mock): void {
        $mock->allows([
            'execute' => static fn (string $key): ?string => $key === 'morph_map.event' ? null : null,
        ]);
    });

    $module = new class
    {
        public function getName(): string
        {
            return 'Meetup';
        }
    };

    Module::partialMock()->allows([
        'allEnabled' => [$module],
    ]);

    $this->mockService(GetAllModelsByModuleNameAction::class, function ($mock): void {
        $mock->allows([
            'execute' => static fn (string $moduleName): array => $moduleName === 'Meetup'
                ? ['event' => 'Modules\Meetup\Models\Event']
                : [],
        ]);
    });

    $this->mockService(SaveTenantConfigAction::class, function ($mock): void {
        $mock->allows([
            'execute' => true,
        ]);
    });

    $action = app(ResolveTenantModelClassAction::class);
    $result = $action->execute('event');

    Assert::assertSame('Modules\Meetup\Models\Event', $result);
});

test('throws exception for unknown model', function (): void {
    /** @var TestCase $this */
    $this->mockService(ResolveTenantConfigValueAction::class, function ($mock): void {
        $mock->allows([
            'execute' => null,
        ]);
    });

    Module::partialMock()->allows([
        'allEnabled' => [],
    ]);

    $action = app(ResolveTenantModelClassAction::class);

    try {
        $action->execute('unknown_model');
        Assert::fail('Expected exception was not thrown');
    } catch (Exception $exception) {
        Assert::assertInstanceOf(Exception::class, $exception);
    }
});
