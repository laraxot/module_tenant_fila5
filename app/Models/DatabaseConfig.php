<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

<<<<<<< .merge_file_JKvXLz
<<<<<<< HEAD
/**
=======
use Modules\Xot\Contracts\ProfileContract;

/**
=======
use Modules\Xot\Contracts\ProfileContract;

/**
>>>>>>> .merge_file_D7rnKt
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
 * @property array<string, mixed>|null $options
 *
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 *
 * @method static \Modules\Tenant\Database\Factories\DatabaseConfigFactory factory($count = null, $state = [])
<<<<<<< .merge_file_JKvXLz
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_D7rnKt
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig query()
 *
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
<<<<<<< HEAD
=======
            'password' => 'encrypted',
>>>>>>> 1ad0554 (.)
            'prefix_indexes' => 'boolean',
            'strict' => 'boolean',
            'options' => 'array',
        ]);
    }
}
