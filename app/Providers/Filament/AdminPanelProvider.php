<?php

declare(strict_types=1);

namespace Modules\Tenant\Providers\Filament;

<<<<<<< HEAD
use Filament\Panel;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use Override;
=======
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
>>>>>>> 1ad0554 (.)

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Tenant';
<<<<<<< HEAD

    #[Override]
    public function panel(Panel $panel): Panel
    {
        return parent::panel($panel);
    }
=======
>>>>>>> 1ad0554 (.)
}
