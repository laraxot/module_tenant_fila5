<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\User\Models\User;
use Sushi\Sushi;

/**
 * @property string|null $id
 * @property string|null $name
 * @property-read \Modules\WorkOrder\Models\Profile|null $creator
 * @property-read \Modules\WorkOrder\Models\Profile|null $deleter
 * @property-read \Modules\WorkOrder\Models\Profile|null $updater
 * @method static \Modules\Tenant\Database\Factories\TenantDomainFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TenantDomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TenantDomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TenantDomain query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TenantDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TenantDomain whereName($value)
 * @mixin \Eloquent
 */
class TenantDomain extends BaseModel
{
    use Sushi;

    protected $fillable = [
        'tenant_id',
        'name',
        'domain',
        'is_primary',
        'status',
        'verification_token',
        'verified_at',
    ];

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
