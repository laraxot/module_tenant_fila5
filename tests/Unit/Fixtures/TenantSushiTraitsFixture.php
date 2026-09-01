<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToCsv;
use Modules\Tenant\Models\Traits\SushiToPhpArray;

/**
 * Fixture minima: rende i trait Sushi visibili a PHPStan nel perimetro modulo Tenant.
 * Consumer reali: User\SocialProvider (SushiToPhpArray), Sigma\WebService (SushiToCsv).
 */
final class TenantSushiPhpArrayFixture extends Model
{
    use SushiToPhpArray;

    protected $table = 'tenant_sushi_php_fixture';
}

final class TenantSushiCsvFixture extends Model
{
    use SushiToCsv;

    protected $table = 'tenant_sushi_csv_fixture';
}
