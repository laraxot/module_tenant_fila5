<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected string $view = 'tenant::filament.pages.dashboard';
}
