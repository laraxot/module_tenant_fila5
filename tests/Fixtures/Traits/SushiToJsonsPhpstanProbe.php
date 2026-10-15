<?php

declare(strict_types=1);

namespace Tests\Modules\Tenant\Fixtures\Traits;

use Modules\Tenant\Models\BaseModelJsons;

/**
 * @property array<string, mixed> $schema
 */
final class SushiToJsonsPhpstanProbe extends BaseModelJsons
{
    /** @var array<string, mixed> */
    protected $schema = [
        'name' => 'string',
        'status' => 'string',
    ];
}
