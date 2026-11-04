<?php

declare(strict_types=1);

namespace Modules\Tenant\Datas;

use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/** Config tenant per la SettingPage di Tenant, senza chiavi esposte al form. */
class TenantConfigData extends Data
{
    use MakesFromTenantConfig;

    public bool $enabled = true;
<<<<<<< HEAD
=======

    public bool $domain_routing = true;

    public string $default_locale = 'it';
>>>>>>> 16b68b44c3e07a868e8e2810331670e6c5342a9c
}
