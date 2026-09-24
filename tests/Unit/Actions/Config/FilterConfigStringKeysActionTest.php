<?php

declare(strict_types=1);

use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;

it('keeps only string keys', function (): void {
    $action = app(FilterConfigStringKeysAction::class);

    $result = $action->execute([
        'name' => 'Acme',
        'enabled' => true,
        123 => 'numeric key',
        'nested' => ['a' => 1, 'b' => 2],
    ]);

    expect($result)->toBe([
        'name' => 'Acme',
        'enabled' => true,
        'nested' => ['a' => 1, 'b' => 2],
    ]);
});

it('returns an empty array for empty input', function (): void {
    $action = app(FilterConfigStringKeysAction::class);

    expect($action->execute([]))->toBe([]);
});
