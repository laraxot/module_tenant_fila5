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
}
