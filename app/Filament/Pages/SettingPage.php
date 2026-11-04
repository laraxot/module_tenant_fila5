<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Pages;

use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Tenant (`config/{tenant}/tenant.php`), solo super-admin. Pagina senza campi: la
 * convenzione (Data, file del tenant, accesso) sta in BaseSettingPage e in
 * \Modules\Tenant\Datas\TenantConfigData.
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, never>
     */
    protected function getFormSchema(): array
    {
        return [];
    }
}
