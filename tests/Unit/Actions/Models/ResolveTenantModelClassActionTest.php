<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Models;

use Exception;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelClassAction;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;

final class ResolveTenantModelClassActionTest extends TestCase
{
    public function test_resolves_tenant_model_class_from_config(): void
    {
        $this->mockService(ResolveTenantConfigValueAction::class, function ($mock): void {
            /** @phpstan-ignore-next-line */
            $mock->shouldReceive('execute')->andReturnUsing(
                static fn (string $key): ?string => $key === 'morph_map.test_model'
                    ? 'Modules\Test\Models\TestModel'
                    : null,
            );
        });

        $action = app(ResolveTenantModelClassAction::class);
        $result = $action->execute('test_model');

        Assert::assertSame('Modules\Test\Models\TestModel', $result);
    }

    public function test_resolves_tenant_model_class_by_scanning_modules_if_not_in_config(): void
    {
        $this->mockService(ResolveTenantConfigValueAction::class, function ($mock): void {
            /** @phpstan-ignore-next-line */
            $mock->shouldReceive('execute')->andReturnUsing(
                static fn (string $key): ?string => $key === 'morph_map.event' ? null : null,
            );
        });

        $module = new class
        {
            public function getName(): string
            {
                return 'Meetup';
            }
        };

        /** @phpstan-ignore-next-line */
        Module::partialMock()->shouldReceive('allEnabled')->andReturn([$module]);

        $this->mockService(GetAllModelsByModuleNameAction::class, function ($mock): void {
            /** @phpstan-ignore-next-line */
            $mock->shouldReceive('execute')->andReturnUsing(
                static fn (string $moduleName): array => $moduleName === 'Meetup'
                    ? ['event' => Tenant::class]
                    : [],
            );
        });

        $this->mockService(SaveTenantConfigAction::class, function ($mock): void {
            /** @phpstan-ignore-next-line */
            $mock->shouldReceive('execute')->andReturnNull();
        });

        $action = app(ResolveTenantModelClassAction::class);
        $result = $action->execute('event');

        Assert::assertSame(Tenant::class, $result);
    }

    public function test_throws_exception_for_unknown_model(): void
    {
    $this->mockService(ResolveTenantConfigValueAction::class, function ($mock): void {
        /** @phpstan-ignore-next-line */
        $mock->shouldReceive('execute')->andReturnNull();
        });

        /** @phpstan-ignore-next-line */
        Module::partialMock()->shouldReceive('allEnabled')->andReturn([]);

        $action = app(ResolveTenantModelClassAction::class);

        try {
            $action->execute('unknown_model');
            Assert::fail('Expected exception was not thrown');
        } catch (Exception $exception) {
            Assert::assertInstanceOf(Exception::class, $exception);
        }
    }
}
