<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Support\Carbon;
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Models\Traits\SushiToCsv;

/**
 * Fixture di coverage per il trait `SushiToCsv`, in memoria.
 *
 * L'host storico era `Modules\Sigma\Models\WebService`, che in questo repository
 * non esiste: estenderlo rendeva la fixture non caricabile e portava una
 * dipendenza da Sigma dentro i test di Tenant. Il soggetto del test e' il trait,
 * quindi la fixture lo compone direttamente sul `BaseModel` del modulo.
 *
 * Le colonne sono dichiarate qui perche' `SushiToCsv` le scrive (`$model->updated_at`,
 * `$model->created_at`) e un modello Sushi non ha una migrazione da cui dedurle.
 *
 * @property int|string|null $id
 * @property string|null $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|string|null $created_by
 * @property int|string|null $updated_by
 */
final class SushiToCsvCoverageModel extends BaseModel
{
    use SushiToCsv;

    /** @var string */
    protected $table = 'sushi_csv_coverage';

    /** @var list<string> */
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
