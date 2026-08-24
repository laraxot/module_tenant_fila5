<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Modules\Sigma\Models\WebService;

/**
 * Fixture di coverage: stesso trait dell'host reale `WebService`, in memoria.
 */
final class SushiToCsvCoverageModel extends WebService
{
    protected $table = 'sushi_csv_coverage';

    protected $fillable = [
        'id',
        'name',
        'updated_at',
        'updated_by',
        'created_at',
        'created_by',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }
}
