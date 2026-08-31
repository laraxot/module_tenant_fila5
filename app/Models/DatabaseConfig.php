<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Modules\User\Models\User;

/**
 * @property-read \Modules\WorkOrder\Models\Profile|null $creator
 * @property-read \Modules\WorkOrder\Models\Profile|null $deleter
 * @property-read \Modules\WorkOrder\Models\Profile|null $updater
 * @method static \Modules\Tenant\Database\Factories\DatabaseConfigFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\DatabaseConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\DatabaseConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\DatabaseConfig query()
 * @mixin \Eloquent
 */
class DatabaseConfig extends BaseModel
{
    protected $table = 'database_configs';

    protected $fillable = [
        'host',
        'port',
        'database',
        'username',
        'password',
        'charset',
        'collation',
        'prefix',
        'prefix_indexes',
        'strict',
        'engine',
        'options',
    ];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'port' => 'integer',
            'prefix_indexes' => 'boolean',
            'strict' => 'boolean',
            'options' => 'array',
        ]);
    }
}
