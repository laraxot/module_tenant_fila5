<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Tenant (`config/{tenant}/tenant.php`), solo super-admin. Pagina senza campi: la
 * convenzione (Data, file del tenant, accesso) sta in BaseSettingPage e in
 * \Modules\Tenant\Datas\TenantConfigData.
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, Select|Toggle>
     */
    protected function getFormSchema(): array
    {
        return [
            'enabled' => Toggle::make('enabled')->default(true),
            'domain_routing' => Toggle::make('domain_routing')->default(true),
            'default_locale' => Select::make('default_locale')->options(['it' => 'Italiano', 'en' => 'English'])->required(),
        ];
    }
}
