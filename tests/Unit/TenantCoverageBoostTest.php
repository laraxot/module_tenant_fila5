<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Mockery;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use Modules\Tenant\Actions\Config\MergeRecursiveStringKeyConfigAction;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Services\Config\Resolvers\StandardConfigResolver;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

describe('Tenant coverage boost — Config actions', function (): void {
    test('FilterConfigStringKeysAction keeps only string keys', function (): void {
        $result = app(FilterConfigStringKeysAction::class)->execute([
            'valid' => 1,
            0 => 'ignored',
            'nested' => ['a' => 1],
        ]);

        Assert::assertSame(['valid' => 1, 'nested' => ['a'  => 1]], $result);
        Assert::assertArrayNotHasKey(0, $result);
    });

    test('MergeRecursiveStringKeyConfigAction merges nested configs', function (): void {
        $merged = app(MergeRecursiveStringKeyConfigAction::class)->execute(
            ['mail' => ['driver' => 'smtp', 'host' => 'localhost']],
            ['mail' => ['host' => 'tenant-host'], 1 => 'skip'],
        );

        $mail = $merged['mail'];
        Assert::assertIsArray($mail);
        Assert::assertSame('tenant-host', $mail['host']);
        Assert::assertSame('smtp', $mail['driver']);
    });
});

describe('Tenant coverage boost — Domain sushi', function (): void {
    test('Domain getRows loads from GetDomainsArrayAction', function (): void {
        /** @var TestCase $this */
        $this->mockService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => [
                ['id' => 1, 'name' => 'tenant.example.com'],
            ]]);
        });

        $rows = (new Domain())->getRows();

        Assert::assertCount(1, $rows);
        Assert::assertSame('tenant.example.com', $rows[0]['name']);
    });
});

describe('Tenant coverage boost — Models and resolvers', function (): void {
    test('Tenant isActive reflects is_active attribute', function (): void {
        $active = new Tenant(['is_active' => true]);
        $inactive = new Tenant(['is_active' => false]);

        Assert::assertTrue($active->isActive());
        Assert::assertFalse($inactive->isActive());
    });

    test('StandardConfigResolver resolves existing config keys', function (): void {
        config(['app' => ['name' => 'Base App', 'locale' => 'it']]);

        $resolver = new StandardConfigResolver();

        Assert::assertTrue($resolver->canResolve('app.name'));
        Assert::assertSame('Base App', $resolver->resolve('app.name'));

        expect(fn (): mixed => $resolver->resolve('app.missing', 'fallback'))
            ->toThrow(\Exception::class, 'Configuration key not found: app.missing');
    });
});
