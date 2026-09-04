<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Modules\User\Models\User;

/**
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig query()
 * @property string $id
 * @property string|null $host
 * @property int|null $port
 * @property string|null $database
 * @property string|null $username
 * @property string|null $password
 * @property string|null $charset
 * @property string|null $collation
 * @property string|null $prefix
 * @property bool|null $prefix_indexes
 * @property bool|null $strict
 * @property string|null $engine
 * @property array<array-key, mixed>|null $options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\Quaeris\Models\Profile|null $deleter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereCharset($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereCollation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereDatabase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereEngine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig wherePrefixIndexes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereStrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig whereUsername($value)
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
