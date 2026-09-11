<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\User;

/**
 * @property string|null $tenant_id
 * @property string|null $key
 * @property mixed $value
 * @property string|null $type
 * @property-read User|null $creator
 * @property-read Tenant|null $tenant
 * @property-read User|null $updater
 * @method static Builder<static>|TenantSetting newModelQuery()
 * @method static Builder<static>|TenantSetting newQuery()
 * @method static Builder<static>|TenantSetting query()
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\User\Models\Profile|null $deleter
 * @method static Builder<static>|TenantSetting whereCreatedAt($value)
 * @method static Builder<static>|TenantSetting whereCreatedBy($value)
 * @method static Builder<static>|TenantSetting whereDeletedAt($value)
 * @method static Builder<static>|TenantSetting whereDeletedBy($value)
 * @method static Builder<static>|TenantSetting whereId($value)
 * @method static Builder<static>|TenantSetting whereKey($value)
 * @method static Builder<static>|TenantSetting whereTenantId($value)
 * @method static Builder<static>|TenantSetting whereType($value)
 * @method static Builder<static>|TenantSetting whereUpdatedAt($value)
 * @method static Builder<static>|TenantSetting whereUpdatedBy($value)
 * @method static Builder<static>|TenantSetting whereValue($value)
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
