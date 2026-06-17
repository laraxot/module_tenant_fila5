<?php

declare(strict_types=1);

/** @var mixed $databaseConfig */
$databaseConfig = config('database', []);

if (! is_array($databaseConfig)) {
    return [
        'default' => 'sqlite',
        'connections' => [],
    ];
}

/** @var array<string, mixed> $databaseConfig */
return $databaseConfig;
