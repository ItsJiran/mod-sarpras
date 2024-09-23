<?php

namespace Module\Infrastructure\Policies;

use Module\System\Models\SystemUser;
use Module\Infrastructure\Models\InfrastructureAsset;
use Illuminate\Auth\Access\Response;

class InfrastructureAssetPolicy
{
    /**
    * Perform pre-authorization checks.
    */
    public function before(SystemUser $user, string $ability): bool|null
    {
        if ($user->hasAbility('infrastructure-superadmin')) {
            return true;
        }
    
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function view(SystemUser $user): bool
    {
        return $user->hasPermission('view-infrastructure-asset');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, InfrastructureAsset $infrastructureAsset): bool
    {
        return $user->hasPermission('show-infrastructure-asset');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-infrastructure-asset');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, InfrastructureAsset $infrastructureAsset): bool
    {
        return $user->hasPermission('update-infrastructure-asset');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, InfrastructureAsset $infrastructureAsset): bool
    {
        return $user->hasPermission('delete-infrastructure-asset');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, InfrastructureAsset $infrastructureAsset): bool
    {
        return $user->hasPermission('restore-infrastructure-asset');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, InfrastructureAsset $infrastructureAsset): bool
    {
        return $user->hasPermission('destroy-infrastructure-asset');
    }
}
