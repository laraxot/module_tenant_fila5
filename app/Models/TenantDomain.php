<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Sushi\Sushi;

/**
 * @property string|null $id
 * @property string|null $tenant_id
 * @property string|null $name
 * @property string|null $domain
 * @property bool $is_primary
=======
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Database\Factories\TenantDomainFactory;
use Modules\Xot\Contracts\ProfileContract;
use Sushi\Sushi;

/**
 * @property int|null $id
 * @property string|int|null $tenant_id
 * @property string|null $name
 * @property string|null $domain
 * @property bool|null $is_primary
>>>>>>> 1ad0554 (.)
 * @property string|null $status
 * @property string|null $verification_token
 * @property Carbon|null $verified_at
 *
<<<<<<< HEAD
 * @method static Builder<static>|TenantDomain newModelQuery()
 * @method static Builder<static>|TenantDomain newQuery()
 * @method static Builder<static>|TenantDomain query()
 * @method static Builder<static>|TenantDomain whereId($value)
 * @method static Builder<static>|TenantDomain whereName($value)
=======
 * @method static Builder|TenantDomain newModelQuery()
 * @method static Builder|TenantDomain newQuery()
 * @method static Builder|TenantDomain query()
 * @method static Builder|TenantDomain whereId($value)
 * @method static Builder|TenantDomain whereName($value)
 * @method static Builder|TenantDomain whereDomain($value)
 * @method static Builder|TenantDomain whereIsPrimary($value)
 * @method static Builder|TenantDomain whereStatus($value)
 * @method static Builder|TenantDomain whereVerificationToken($value)
 * @method static Builder|TenantDomain whereVerifiedAt($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 *
 * @method static TenantDomainFactory factory($count = null, $state = [])
>>>>>>> 1ad0554 (.)
 *
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
