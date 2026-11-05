<?php

declare(strict_types=1);

namespace Modules\Tenant\Datas;

use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di Tenant del tenant corrente: `config/{tenant}/tenant.php`.
 *
 * Si modificano dalla SettingPage del modulo (solo super-admin).
 */
class TenantConfigData extends Data
{
    use MakesFromTenantConfig;

    /** Abilita il modulo Tenant. */
    public bool $enabled = true;

    /** Routing per dominio: ogni tenant risponde su un dominio diverso. */
    public bool $domain_routing = true;

    /** Lingua predefinita del tenant. */
    public string $default_locale = 'it';

    /** Nome del brand: compare nei pannelli e nel front office. */
    public string $title = '';

    /** Altezza del logo nei pannelli (es. 2em, 32px). */
    public string $logo_height = '2em';
}
