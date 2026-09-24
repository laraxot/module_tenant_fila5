<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

<<<<<<< .merge_file_Dv3YUa
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Builder;
>>>>>>> .merge_file_hmAhoz
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Database\Factories\TestSushiModelFactory;
use Modules\Tenant\Models\Traits\SushiToJson;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
<<<<<<< .merge_file_Dv3YUa
=======
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use Modules\Tenant\Database\Factories\TestSushiModelFactory;
use Modules\Tenant\Models\Traits\SushiToJson;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
=======
>>>>>>> .merge_file_hmAhoz
 * Modello di test per il trait SushiToJson.
 *
 * Utilizzato esclusivamente per i test del trait.
 *
<<<<<<< .merge_file_Dv3YUa
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_hmAhoz
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $status
 * @property array<array-key, mixed>|null $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
<<<<<<< .merge_file_Dv3YUa
<<<<<<< HEAD
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @method static \Modules\Tenant\Database\Factories\TestSushiModelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereUpdatedBy($value)
=======
 *
=======
 *
>>>>>>> .merge_file_hmAhoz
 * @method static TestSushiModelFactory factory($count = null, $state = [])
 * @method static Builder<static>|TestSushiModel newModelQuery()
 * @method static Builder<static>|TestSushiModel newQuery()
 * @method static Builder<static>|TestSushiModel query()
 * @method static Builder<static>|TestSushiModel whereCreatedAt($value)
 * @method static Builder<static>|TestSushiModel whereDescription($value)
 * @method static Builder<static>|TestSushiModel whereId($value)
 * @method static Builder<static>|TestSushiModel whereMetadata($value)
 * @method static Builder<static>|TestSushiModel whereName($value)
 * @method static Builder<static>|TestSushiModel whereStatus($value)
 * @method static Builder<static>|TestSushiModel whereUpdatedAt($value)
 *
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
<<<<<<< .merge_file_Dv3YUa
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_hmAhoz
 *
 * @mixin \Eloquent
 */
class TestSushiModel extends BaseModel
{
<<<<<<< .merge_file_Dv3YUa
<<<<<<< HEAD
    use SushiToJson;

    /**
=======
    /** @phpstan-use HasXotFactory<TestSushiModelFactory> */
    use HasXotFactory;
=======
    use HasXotFactory;

>>>>>>> .merge_file_hmAhoz
    use SushiToJson;

    /**
     * Schema esplicito per Sushi quando non ci sono righe.
     *
<<<<<<< .merge_file_Dv3YUa
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_hmAhoz
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

<<<<<<< .merge_file_Dv3YUa
<<<<<<< HEAD
    protected $table = 'test_sushi';

=======
=======
>>>>>>> .merge_file_hmAhoz
    /**
     * La tabella associata al modello.
     */
    protected $table = 'test_sushi';

    /**
     * Nota: non esporre i metodi protetti del trait.
     * I metodi del trait vengono utilizzati internamente dagli eventi Eloquent.
     */

    /**
     * Gli attributi che sono assegnabili in massa.
     */
<<<<<<< .merge_file_Dv3YUa
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_hmAhoz
    protected $fillable = [
        'name',
        'description',
        'status',
        'metadata',
        'created_by',
        'updated_by',
    ];

<<<<<<< .merge_file_Dv3YUa
<<<<<<< HEAD
=======
    /**
     * Override del path JSON in ambiente di test per NON toccare config/local/<nome progetto>/.
     */
>>>>>>> 1ad0554 (.)
=======
    /**
     * Override del path JSON in ambiente di test per NON toccare config/local/<nome progetto>/.
     */
>>>>>>> .merge_file_hmAhoz
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
<<<<<<< .merge_file_Dv3YUa
<<<<<<< HEAD
        return app(GetTenantFilePathAction::class)->execute('database/content/'.$this->getTable().'.json');
    }

    /**
=======
        $tbl = $this->getTable();
        $filePath = app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('database/content/'.$tbl.'.json');
        if (! is_string($filePath)) {
            throw new InvalidArgumentException('File path must be string');
        }

        return $filePath;
    }

    /**
     * Implementa il metodo getRows() richiesto da Sushi.
     * Delega al metodo getSushiRows() del trait.
     *
>>>>>>> 1ad0554 (.)
=======
        $tbl = $this->getTable();
        $filePath = app(GetTenantFilePathAction::class)->execute('database/content/'.$tbl.'.json');
        if (! is_string($filePath)) {
            throw new InvalidArgumentException('File path must be string');
        }

        return $filePath;
    }

    /**
     * Implementa il metodo getRows() richiesto da Sushi.
     * Delega al metodo getSushiRows() del trait.
     *
>>>>>>> .merge_file_hmAhoz
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

<<<<<<< .merge_file_Dv3YUa
<<<<<<< HEAD
=======
=======
>>>>>>> .merge_file_hmAhoz
    /**
     * Gli attributi che devono essere convertiti.
     *
     * @return array<string, string>
     */
<<<<<<< .merge_file_Dv3YUa
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_hmAhoz
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
