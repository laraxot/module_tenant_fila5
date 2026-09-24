<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
<<<<<<< .merge_file_ZWeFqS
<<<<<<< HEAD

/**
=======
use Modules\Tenant\Database\Factories\TenantSettingFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * @property int|null $id
>>>>>>> 1ad0554 (.)
=======
use Modules\Tenant\Database\Factories\TenantSettingFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * @property int|null $id
>>>>>>> .merge_file_ZRIpSM
 * @property string|null $tenant_id
 * @property string|null $key
 * @property string|null $value
 * @property string|null $type
<<<<<<< .merge_file_ZWeFqS
<<<<<<< HEAD
 * @property-read Tenant|null $tenant
 *
 * @method static Builder<static>|TenantSetting newModelQuery()
 * @method static Builder<static>|TenantSetting newQuery()
 * @method static Builder<static>|TenantSetting query()
=======
 *
=======
 *
>>>>>>> .merge_file_ZRIpSM
 * @method static Builder|TenantSetting newModelQuery()
 * @method static Builder|TenantSetting newQuery()
 * @method static Builder|TenantSetting query()
 * @method static Builder|TenantSetting whereId($value)
 * @method static Builder|TenantSetting whereTenantId($value)
 * @method static Builder|TenantSetting whereKey($value)
 * @method static Builder|TenantSetting whereValue($value)
 * @method static Builder|TenantSetting whereType($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 *
 * @method static TenantSettingFactory factory($count = null, $state = [])
 *
 * @property-read Tenant|null $tenant
<<<<<<< .merge_file_ZWeFqS
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_ZRIpSM
 *
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
