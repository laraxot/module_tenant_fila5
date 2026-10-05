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
 * @method string getRouteKey()
 * @method string getRouteKeyName()
 * @method string getTable()
 * @method \Illuminate\Database\Eloquent\Builder<Model> with(array<int, string> $array)
 * @method list<string> getFillable()
 * @method static fill(array<string, mixed> $array)
 * @method \Illuminate\Database\Connection getConnection()
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
 * @mixin \Eloquent
 */
interface HasSushiToJson
{
    /**
     * non possiamo mettere :array perche' Sushi lo richiede come array<int, array<string, mixed>>
     * @return array<int, array<string, mixed>>
     */
    public function getRows();
}
