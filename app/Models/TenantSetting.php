<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\User;

/**
 * @property-read \Modules\WorkOrder\Models\Profile|null $creator
 * @property-read \Modules\WorkOrder\Models\Profile|null $deleter
 * @property-read \Modules\Tenant\Models\Tenant|null $tenant
 * @property-read \Modules\WorkOrder\Models\Profile|null $updater
 * @method static \Modules\Tenant\Database\Factories\TenantSettingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TenantSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TenantSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Modules\Tenant\Models\TenantSetting query()
 * @mixin \Eloquent
 */
class TenantSetting extends BaseModel
{
    protected $fillable = [
        'tenant_id',
        'key',
        'value',
        'type',
    ];

    /** @return BelongsTo<Tenant, $this> */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
