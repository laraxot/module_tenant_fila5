<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * Modules\Tenant\Models\Contracts\HasSushiToJson
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $post_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $title
 * @property bool $is_reclamed
 * @property bool $table_enable
 * @property Pivot|null $pivot
 * @property string $tennant_name
 *
<<<<<<< .merge_file_Il8EQ2
 * @method string getRouteKey()
=======
* @method string getRouteKey()
>>>>>>> .merge_file_Zuh8Il
 * @method string getRouteKeyName()
 * @method string getTable()
 * @method \Illuminate\Database\Eloquent\Builder<Model> with(array<int, string> $array)
 * @method list<string> getFillable()
 * @method static fill(array<string, mixed> $array)
<<<<<<< .merge_file_Il8EQ2
 * @method \Illuminate\Database\Connection getConnection()
=======
 * @method \Illuminate\Database\ConnectionInterface getConnection()
>>>>>>> .merge_file_Zuh8Il
 * @method bool update(array<string, mixed> $params)
 * @method bool|null delete()
 * @method int detach(mixed $params)
 * @method void attach(mixed $params)
 * @method array<string, mixed> treeLabel()
 * @method array<string, mixed> treeSons()
 * @method array<string, mixed> toArray()
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo<Model, Model> user()
 * @method mixed getAttributeValue(string $key)
 *
 * @phpstan-require-extends Model
 *
<<<<<<< .merge_file_Il8EQ2
 * @mixin \Eloquent
=======
 * @mixin Model
>>>>>>> .merge_file_Zuh8Il
 */
interface HasSushiToJson
{
    /**
     * non possiamo mettere :array perche' Sushi lo richiede come array<int, array<string, mixed>>
<<<<<<< .merge_file_Il8EQ2
     * @return array<int, array<string, mixed>>
     */
    public function getRows();
=======
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRows();

    /**
     * Percorso assoluto del file JSON che alimenta la tabella in-memory.
     *
     * Implementato da `Modules\Tenant\Models\Traits\SushiToJson::getJsonFile()`
     * e sovrascritto dai modelli concreti che vogliano un percorso diverso
     * (es. `TestSushiModel` in ambiente `testing`).
     */
    public function getJsonFile(): string;

    /**
     * Schema delle colonne della tabella in-memory, come definito da Sushi.
     *
     * Sovrascritto dal trait `SushiToJson` con il tipo esplicito per eliminare
     * l'`mixed` restituito dalla firma vendor `Sushi::getSchema()`.
     *
     * @return array<string, string>
     */
    public function getSchema(): array;
>>>>>>> .merge_file_Zuh8Il
}
