<?php

declare(strict_types=1);

use App\Application;
use PHPUnit\Framework\Assert;

use function Safe\mkdir;
use function Safe\realpath;

test('returns real path when requested public path exists', function (): void {
    $root = sys_get_temp_dir().'/appcov-'.uniqid('', true);
    $basePath = $root.'/laravel';
    $publicDir = $root.'/public_html';
    $assetDir = $publicDir.'/assets';

    mkdir($basePath, 0o777, true);
    mkdir($assetDir, 0o777, true);

    $app = new Application($basePath);
    $result = $app->publicPath('assets');

    Assert::assertSame(realpath($assetDir), $result);
});

test('returns base real path plus requested segment when segment does not exist', function (): void {
    $root = sys_get_temp_dir().'/appcov-'.uniqid('', true);
    $basePath = $root.'/laravel';
    $publicDir = $root.'/public_html';

    mkdir($basePath, 0o777, true);
    mkdir($publicDir, 0o777, true);

    $app = new Application($basePath);
    $result = $app->publicPath('missing/file.txt');

    Assert::assertSame(realpath($publicDir).'/missing/file.txt', $result);
});

test('returns plain fallback path when public_html base path does not exist', function (): void {
    $root = sys_get_temp_dir().'/appcov-'.uniqid('', true);
    $basePath = $root.'/laravel';

    mkdir($basePath, 0o777, true);

    $app = new Application($basePath);
    $result = $app->publicPath('foo/bar');

    Assert::assertSame($basePath.'/../public_html/foo/bar', $result);
});
