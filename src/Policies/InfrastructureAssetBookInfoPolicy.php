<?php

namespace Module\Infrastructure\Policies;

use Module\System\Models\SystemUser;
use Module\Infrastructure\Models\InfrastructureAssetBookInfo;
use Illuminate\Auth\Access\Response;

class InfrastructureAssetBookInfoPolicy
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
        return $user->hasPermission('view-infrastructure-assetbookinfo');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, InfrastructureAssetBookInfo $infrastructureAssetBookInfo): bool
    {
        return $user->hasPermission('show-infrastructure-assetbookinfo');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-infrastructure-assetbookinfo');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, InfrastructureAssetBookInfo $infrastructureAssetBookInfo): bool
    {
        return $user->hasPermission('update-infrastructure-assetbookinfo');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, InfrastructureAssetBookInfo $infrastructureAssetBookInfo): bool
    {
        return $user->hasPermission('delete-infrastructure-assetbookinfo');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, InfrastructureAssetBookInfo $infrastructureAssetBookInfo): bool
    {
        return $user->hasPermission('restore-infrastructure-assetbookinfo');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, InfrastructureAssetBookInfo $infrastructureAssetBookInfo): bool
    {
        return $user->hasPermission('destroy-infrastructure-assetbookinfo');
    }
}
