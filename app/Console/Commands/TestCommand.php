<?php

declare(strict_types=1);

namespace Modules\Tenant\Console\Commands;

use Illuminate\Console\Command;
use Modules\Tenant\Actions\GetTenantNameAction;

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
        $name = app(GetTenantNameAction::class)->execute();
>>>>>>> laraxot/dev
        $this->info('tenant name :'.$name);
    }
}
