<?php

declare(strict_types=1);
<<<<<<< .merge_file_79huky
<<<<<<< HEAD
=======

>>>>>>> .merge_file_N5Lvte
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use PHPUnit\Framework\Assert;

it('keeps only string keys', function (): void {
    $result = app(FilterConfigStringKeysAction::class)->execute([
=======

use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;

it('keeps only string keys', function (): void {
    $action = app(FilterConfigStringKeysAction::class);

    $result = $action->execute([
>>>>>>> 1ad0554 (.)
        'name' => 'Acme',
        'enabled' => true,
        123 => 'numeric key',
        'nested' => ['a' => 1, 'b' => 2],
    ]);

<<<<<<< HEAD
    Assert::assertSame([
        'name' => 'Acme',
        'enabled' => true,
        'nested' => ['a' => 1, 'b' => 2],
    ], $result);
});

it('returns an empty array for empty input', function (): void {
    Assert::assertSame([], app(FilterConfigStringKeysAction::class)->execute([]));
=======
    expect($result)->toBe([
        'name' => 'Acme',
        'enabled' => true,
        'nested' => ['a' => 1, 'b' => 2],
    ]);
});

it('returns an empty array for empty input', function (): void {
    $action = app(FilterConfigStringKeysAction::class);

    expect($action->execute([]))->toBe([]);
>>>>>>> 1ad0554 (.)
});
