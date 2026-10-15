<?php

declare(strict_types=1);

namespace Tests\Modules\Tenant\Fixtures\Traits;

use Modules\Tenant\Models\Traits\SushiToCsv;

final class SushiToCsvPhpstanProbe extends TenantPhpstanProbeModel
{
    use SushiToCsv;
}
