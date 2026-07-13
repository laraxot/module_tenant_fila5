<?php

declare(strict_types=1);

namespace Modules\Tenant\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'tenant:test';

    protected $description = 'Check Tenant';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = app(\Modules\Tenant\Actions\GetTenantNameAction::class)->execute();
        $this->info('tenant name :'.$name);
    }
}
