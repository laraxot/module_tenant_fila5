<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Database\Factories\DomainFactory;
use Modules\User\Models\User;
use Modules\Xot\Models\Traits\HasXotFactory;
use Sushi\Sushi;

/**
 * @property string|null $id
 * @property string|null $name
 * @property-read \Modules\WorkOrder\Models\Profile|null $creator
 * @property-read \Modules\WorkOrder\Models\Profile|null $deleter
 * @property-read \Modules\WorkOrder\Models\Profile|null $updater
 * @method static \Modules\Tenant\Database\Factories\DomainFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\Domain whereName($value)
 * @mixin \Eloquent
 */
class Domain extends BaseModel
{
    /** @use HasXotFactory<DomainFactory> */
    use HasXotFactory;

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
