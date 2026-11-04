<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Pages;

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
     * @return array<string, Toggle>
     */
    protected function getFormSchema(): array
    {
        return [
            'enabled' => Toggle::make('enabled')->default(true)->required(),
        ];
    }
}
