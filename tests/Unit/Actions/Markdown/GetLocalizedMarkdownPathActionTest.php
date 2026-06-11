<?php

declare(strict_types=1);

use Illuminate\Support\Facades\App;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Markdown\GetLocalizedMarkdownPathAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_put_contents;
use function Safe\unlink;

uses(TestCase::class);

test('gets localized markdown path if it exists', function (): void {
    /** @var TestCase $this */
    App::setLocale('it');

    $tempDir = sys_get_temp_dir();
    $tempFile = $tempDir.'/test.md';
    file_put_contents($tempFile, 'test');

    $this->mockService(GetTenantFilePathAction::class, function ($mock) use ($tempFile): void {
        $mock->allows([
            'execute' => static function (string $path) use ($tempFile): string {
                return match ($path) {
                    'lang/it/test.md' => $tempFile,
                    default => '/non/existent/path.md',
                };
            },
        ]);
    });

    $action = app(GetLocalizedMarkdownPathAction::class);
    $result = $action->execute('test.md');

    Assert::assertSame($tempFile, $result);
    unlink($tempFile);
});

test('gets fallback markdown path if localized does not exist', function (): void {
    /** @var TestCase $this */
    App::setLocale('it');

    $tempDir = sys_get_temp_dir();
    $tempFile = $tempDir.'/fallback.md';
    file_put_contents($tempFile, 'test');

    $this->mockService(GetTenantFilePathAction::class, function ($mock) use ($tempFile): void {
        $mock->allows([
            'execute' => static function (string $path) use ($tempFile): string {
                return match ($path) {
                    'lang/it/fallback.md' => '/non/existent/path.md',
                    'fallback.md' => $tempFile,
                    default => '/non/existent/path.md',
                };
            },
        ]);
    });

    $action = app(GetLocalizedMarkdownPathAction::class);
    $result = $action->execute('fallback.md');

    Assert::assertSame($tempFile, $result);
    unlink($tempFile);
});

test('returns hash if no path exists', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetTenantFilePathAction::class, function ($mock): void {
        $mock->allows([
            'execute' => '/non/existent/path.md',
        ]);
    });

    $action = app(GetLocalizedMarkdownPathAction::class);
    $result = $action->execute('none.md');

    Assert::assertSame('#', $result);
});
