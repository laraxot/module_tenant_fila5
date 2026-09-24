<?php

declare(strict_types=1);

namespace Modules\Tenant\Console\Commands;

use Illuminate\Console\Command;
<<<<<<< HEAD
use Modules\Tenant\Actions\GetTenantNameAction;
=======
>>>>>>> 1ad0554 (.)

class TestCommand extends Command
{
    protected $signature = 'tenant:test';

    protected $description = 'Check Tenant';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
<<<<<<< HEAD
        $name = app(GetTenantNameAction::class)->execute();
=======
        $name = app(\Modules\Tenant\Actions\GetTenantNameAction::class)->execute();
>>>>>>> 1ad0554 (.)
        $this->info('tenant name :'.$name);
    }
}
