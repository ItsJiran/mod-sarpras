<?php

namespace Module\Infrastructure\Policies;

use Module\System\Models\SystemUser;
use Module\Infrastructure\Models\InfrastructureTaxAsset;
use Illuminate\Auth\Access\Response;

class InfrastructureTaxAssetPolicy
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
        return $user->hasPermission('view-infrastructure-taxasset');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, InfrastructureTaxAsset $infrastructureTaxAsset): bool
    {
        return $user->hasPermission('show-infrastructure-taxasset');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-infrastructure-taxasset');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, InfrastructureTaxAsset $infrastructureTaxAsset): bool
    {
        return $user->hasPermission('update-infrastructure-taxasset');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, InfrastructureTaxAsset $infrastructureTaxAsset): bool
    {
        return $user->hasPermission('delete-infrastructure-taxasset');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, InfrastructureTaxAsset $infrastructureTaxAsset): bool
    {
        return $user->hasPermission('restore-infrastructure-taxasset');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, InfrastructureTaxAsset $infrastructureTaxAsset): bool
    {
        return $user->hasPermission('destroy-infrastructure-taxasset');
    }
}
