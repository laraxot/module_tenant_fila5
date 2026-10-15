<?php

declare(strict_types=1);

namespace Tests\Modules\Tenant\Fixtures\Traits;

use Modules\Tenant\Models\Traits\SushiToPhpArray;

final class SushiToPhpArrayPhpstanProbe extends TenantPhpstanProbeModel
{
    use SushiToPhpArray;
}
