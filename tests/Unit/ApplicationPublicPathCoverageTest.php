<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use App\Application;
use Modules\Tenant\Tests\TestCase;
<<<<<<< .merge_file_kX9cO4
<<<<<<< HEAD
use PHPUnit\Framework\Assert;
=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_d2G59n

use function Safe\mkdir;
use function Safe\realpath;

uses(TestCase::class);

it('returns real path when requested public path exists', function (): void {
    $root = sys_get_temp_dir().'/appcov-'.uniqid('', true);
    $basePath = $root.'/laravel';
    $publicDir = $root.'/public_html';
    $assetDir = $publicDir.'/assets';

    mkdir($basePath, 0o777, true);
    mkdir($assetDir, 0o777, true);

    $app = new Application($basePath);
    $result = $app->publicPath('assets');

<<<<<<< .merge_file_kX9cO4
<<<<<<< HEAD
    Assert::assertSame(realpath($assetDir), $result);
=======
    expect($result)->toBe(realpath($assetDir));
>>>>>>> 1ad0554 (.)
=======
    expect($result)->toBe(realpath($assetDir));
>>>>>>> .merge_file_d2G59n
});

it('returns base real path plus requested segment when segment does not exist', function (): void {
    $root = sys_get_temp_dir().'/appcov-'.uniqid('', true);
    $basePath = $root.'/laravel';
    $publicDir = $root.'/public_html';

    mkdir($basePath, 0o777, true);
    mkdir($publicDir, 0o777, true);

    $app = new Application($basePath);
    $result = $app->publicPath('missing/file.txt');

<<<<<<< .merge_file_kX9cO4
<<<<<<< HEAD
    Assert::assertSame(realpath($publicDir).'/missing/file.txt', $result);
=======
    expect($result)->toBe(realpath($publicDir).'/missing/file.txt');
>>>>>>> 1ad0554 (.)
=======
    expect($result)->toBe(realpath($publicDir).'/missing/file.txt');
>>>>>>> .merge_file_d2G59n
});

it('returns plain fallback path when public_html base path does not exist', function (): void {
    $root = sys_get_temp_dir().'/appcov-'.uniqid('', true);
    $basePath = $root.'/laravel';

    mkdir($basePath, 0o777, true);

    $app = new Application($basePath);
    $result = $app->publicPath('foo/bar');

<<<<<<< .merge_file_kX9cO4
<<<<<<< HEAD
    Assert::assertSame($basePath.'/../public_html/foo/bar', $result);
=======
    expect($result)->toBe($basePath.'/../public_html/foo/bar');
>>>>>>> 1ad0554 (.)
=======
    expect($result)->toBe($basePath.'/../public_html/foo/bar');
>>>>>>> .merge_file_d2G59n
});
