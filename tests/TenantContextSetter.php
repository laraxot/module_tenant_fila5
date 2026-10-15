<?php

declare(strict_types=1);

namespace Tests\Modules\Tenant;

use Modules\Tenant\Models\Tenant;

interface TenantContextSetter
{
    public function setCurrent(Tenant $tenant): void;
}
