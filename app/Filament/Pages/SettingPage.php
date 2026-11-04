<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Modules\Xot\Filament\Pages\BaseSettingPage;

use Filament\Forms\Components\Toggle;
use Modules\Tenant\Datas\TenantConfigData;

/**
 * Impostazioni di Tenant (`config/{tenant}/tenant.php`), solo super-admin.
 *
 * Form configurato con i campi esposti da TenantConfigData.
 *
 * @see TenantConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
<<<<<<< HEAD
     * @return array<string, Toggle>
=======
     * @return array<string, Select|Toggle>
>>>>>>> 16b68b44c3e07a868e8e2810331670e6c5342a9c
     */
    protected function getFormSchema(): array
    {
        return [
<<<<<<< HEAD
            'enabled' => Toggle::make('enabled')->default(true)->required(),
=======
            'enabled' => Toggle::make('enabled')->default(true),
            'domain_routing' => Toggle::make('domain_routing')->default(true),
            'default_locale' => Select::make('default_locale')->options(['it' => 'Italiano', 'en' => 'English'])->required(),
>>>>>>> 16b68b44c3e07a868e8e2810331670e6c5342a9c
        ];
    }
}
