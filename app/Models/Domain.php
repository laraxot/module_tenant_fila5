<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
<<<<<<< HEAD
use Sushi\Sushi;

/**
 * @property string|null $id
 * @property string|null $name
 *
 * @method static \Modules\Tenant\Database\Factories\DomainFactory factory($count = null, $state = [])
 * @method static Builder<static>|Domain newModelQuery()
 * @method static Builder<static>|Domain newQuery()
 * @method static Builder<static>|Domain query()
 * @method static Builder<static>|Domain whereId($value)
 * @method static Builder<static>|Domain whereName($value)
=======
use Modules\Tenant\Database\Factories\DomainFactory;
use Modules\Xot\Contracts\ProfileContract;
use Sushi\Sushi;

/**
 * @property int|null $id
 * @property string|null $name
 *
 * @method static Builder|Domain newModelQuery()
 * @method static Builder|Domain newQuery()
 * @method static Builder|Domain query()
 * @method static Builder|Domain whereId($value)
 * @method static Builder|Domain whereName($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static DomainFactory factory($count = null, $state = [])
 *
 * @property ProfileContract|null $deleter
>>>>>>> 1ad0554 (.)
 *
 * @mixin \Eloquent
 */
class Domain extends BaseModel
{
    use Sushi;

    /**
     * Model Rows.
     *
     * @return array<int, array<string, string>>
     */
    public function getRows(): array
    {
        return app(GetDomainsArrayAction::class)->execute();
    }
}
