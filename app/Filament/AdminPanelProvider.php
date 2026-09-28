<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament;

use Filament\Panel;
use Modules\Xot\Filament\XotBasePanelProvider;
use Filament\Support\Colors\Color;

class AdminPanelProvider extends XotBasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('Tenant_admin')
            ->path('Tenant/admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: __DIR__.'/Resources', for: 'Modules\\Tenant\\Filament\\Resources')
            ->discoverPages(in: __DIR__.'/Pages', for: 'Modules\\Tenant\\Filament\\Pages')
            ->discoverWidgets(in: __DIR__.'/Widgets', for: 'Modules\\Tenant\\Filament\\Widgets')
            ->discoverClusters(in: __DIR__.'/Clusters', for: 'Modules\\Tenant\\Filament\\Clusters');
    }
}
