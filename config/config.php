<?php

declare(strict_types=1);

return [
    'name' => 'Tenant',
    'description' => 'Modulo per la gestione multi-tenant dell\'applicazione',
<<<<<<< .merge_file_HDbUFK
<<<<<<< HEAD
    'icon' => 'tenant-icon',
=======
    'icon' => 'heroicon-o-building-office',
>>>>>>> 1ad0554 (.)
=======
    'icon' => 'heroicon-o-building-office',
>>>>>>> .merge_file_kkFDfT
    'navigation' => [
        'enabled' => true,
        'sort' => 80,
    ],
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
    ],
    'providers' => [
        'Modules\\Tenant\\Providers\\TenantServiceProvider',
    ],
];
