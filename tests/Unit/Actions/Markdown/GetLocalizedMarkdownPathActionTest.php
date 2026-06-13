<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Markdown;

use Illuminate\Support\Facades\App;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Markdown\GetLocalizedMarkdownPathAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;
use function Safe\file_put_contents;
use function Safe\unlink;

uses(\Modules\Tenant\Tests\TestCase::class);

describe('Get Localized Markdown Path Action', function (): void {
    test('_gets_localized_markdown_path_if_it_exists', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
App::setLocale('it');

        $tempDir = sys_get_temp_dir();
        $tempFile = $tempDir.'/test.md';
        file_put_contents($tempFile, 'test');

        $this->mockService(GetTenantFilePathAction::class, function ($mock) use ($tempFile): void {
            /** @phpstan-ignore-next-line */
            $mock->shouldReceive('execute')->andReturnUsing(
                static function (string $path) use ($tempFile): string {
                    return match ($path) {
                        'lang/it/test.md' => $tempFile,
                        default => '/non/existent/path.md',
                    };
                },
            );
        });

        $action = app(GetLocalizedMarkdownPathAction::class);
        $result = $action->execute('test.md');

        Assert::assertSame($tempFile, $result);
        unlink($tempFile);
    });

    test('_gets_fallback_markdown_path_if_localized_does_not_exist', function (): void {
App::setLocale('it');

        $tempDir = sys_get_temp_dir();
        $tempFile = $tempDir.'/fallback.md';
        file_put_contents($tempFile, 'test');

        $this->mockService(GetTenantFilePathAction::class, function ($mock) use ($tempFile): void {
            /** @phpstan-ignore-next-line */
            $mock->shouldReceive('execute')->andReturnUsing(
                static function (string $path) use ($tempFile): string {
                    return match ($path) {
                        'lang/it/fallback.md' => '/non/existent/path.md',
                        'fallback.md' => $tempFile,
                        default => '/non/existent/path.md',
                    };
                },
            );
        });

        $action = app(GetLocalizedMarkdownPathAction::class);
        $result = $action->execute('fallback.md');

        Assert::assertSame($tempFile, $result);
        unlink($tempFile);
    });

    test('_returns_hash_if_no_path_exists', function (): void {
$this->mockService(GetTenantFilePathAction::class, function ($mock): void {
            /** @phpstan-ignore-next-line */
            $mock->shouldReceive('execute')->andReturn('/non/existent/path.md');
        });

        $action = app(GetLocalizedMarkdownPathAction::class);
        $result = $action->execute('none.md');

        Assert::assertSame('#', $result);
    });
});
