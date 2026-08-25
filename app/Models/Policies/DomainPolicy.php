<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Policies;

use Modules\Tenant\Models\Domain;
use Modules\Xot\Contracts\UserContract;

class DomainPolicy extends TenantBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('domain.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
<<<<<<< HEAD
   public function view(UserContract $user, Domain $domain): bool
=======
    public function view(UserContract $user, Domain $domain): bool
>>>>>>> laraxot/dev
    {
        return $domain->exists && $user->hasPermissionTo('domain.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('domain.create');
    }

    /**
     * Determine whether the user can update the model.
     */
<<<<<<< HEAD
   public function update(UserContract $user, Domain $domain): bool
=======
    public function update(UserContract $user, Domain $domain): bool
>>>>>>> laraxot/dev
    {
        return $domain->exists && $user->hasPermissionTo('domain.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
<<<<<<< HEAD
   public function delete(UserContract $user, Domain $domain): bool
=======
    public function delete(UserContract $user, Domain $domain): bool
>>>>>>> laraxot/dev
    {
        return $domain->exists && $user->hasPermissionTo('domain.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
<<<<<<< HEAD
   public function restore(UserContract $user, Domain $domain): bool
=======
    public function restore(UserContract $user, Domain $domain): bool
>>>>>>> laraxot/dev
    {
        return $domain->exists && $user->hasPermissionTo('domain.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Domain $domain): bool
    {
<<<<<<< HEAD
       return $domain->exists && $user->hasPermissionTo('domain.forceDelete');
=======
        return $domain->exists && $user->hasPermissionTo('domain.forceDelete');
>>>>>>> laraxot/dev
    }
}
