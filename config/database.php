<?php

declare(strict_types=1);

return [
    'default' => config('database.default', 'sqlite'),
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'url' => config('database.connections.sqlite.url'),
            'database' => config('database.connections.sqlite.database', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => config('database.connections.sqlite.foreign_key_constraints', true),
        ],
        'mysql' => [
            'driver' => 'mysql',
            'url' => config('database.connections.mysql.url'),
            'host' => config('database.connections.mysql.host', '127.0.0.1'),
            'port' => config('database.connections.mysql.port', '3306'),
            'database' => config('database.connections.mysql.database', 'laravel'),
            'username' => config('database.connections.mysql.username', 'root'),
            'password' => config('database.connections.mysql.password', ''),
            'unix_socket' => config('database.connections.mysql.unix_socket', ''),
            'charset' => config('database.connections.mysql.charset', 'utf8mb4'),
            'collation' => config('database.connections.mysql.collation', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql')
                ? array_filter([
                    PDO::MYSQL_ATTR_SSL_CA => config('database.connections.mysql.options.'.PDO::MYSQL_ATTR_SSL_CA),
                ]) : [],
        ],
    ],
];
