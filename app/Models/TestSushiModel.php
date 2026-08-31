<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Database\Factories\TestSushiModelFactory;
use Modules\Tenant\Models\Traits\SushiToJson;
use Modules\User\Models\User;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $status
 * @property array<array-key, mixed>|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Modules\WorkOrder\Models\Profile|null $creator
 * @property-read \Modules\WorkOrder\Models\Profile|null $deleter
 * @property-read \Modules\WorkOrder\Models\Profile|null $updater
 * @method static \Modules\Tenant\Database\Factories\TestSushiModelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TestSushiModel whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class TestSushiModel extends BaseModel
{
    /** @use HasXotFactory<TestSushiModelFactory> */
    use HasXotFactory;

    use SushiToJson;

    /**
     * @var array<string, string>
     */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'status' => 'string',
        'metadata' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    protected $table = 'test_sushi';

    protected $fillable = [
        'name',
        'description',
        'status',
        'metadata',
        'created_by',
        'updated_by',
    ];

    public function getJsonFile(): string
    {
        if (app()->environment('testing')) {
            $dir = storage_path('tests/sushi-json');
            if (! File::exists($dir)) {
                File::makeDirectory($dir, 0o755, true, true);
            }

            return $dir.'/test_sushi.json';
        }

        // fallback: usa il comportamento del trait (replicato qui)
        return app(GetTenantFilePathAction::class)->execute('database/content/'.$this->getTable().'.json');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'created_by' => 'integer',
            'updated_by' => 'integer',
        ];
    }
}
