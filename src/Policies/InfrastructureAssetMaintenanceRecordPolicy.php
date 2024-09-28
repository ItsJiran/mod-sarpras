<?php

namespace Module\Infrastructure\Policies;

use Module\System\Models\SystemUser;
use Module\Infrastructure\Models\InfrastructureAssetMaintenanceRecord;
use Illuminate\Auth\Access\Response;

class InfrastructureAssetMaintenanceRecordPolicy
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
        return $user->hasPermission('view-infrastructure-assetmaintenancerecord');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord): bool
    {
        return $user->hasPermission('show-infrastructure-assetmaintenancerecord');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-infrastructure-assetmaintenancerecord');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord): bool
    {
        return $user->hasPermission('update-infrastructure-assetmaintenancerecord');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord): bool
    {
        return $user->hasPermission('delete-infrastructure-assetmaintenancerecord');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord): bool
    {
        return $user->hasPermission('restore-infrastructure-assetmaintenancerecord');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, InfrastructureAssetMaintenanceRecord $infrastructureAssetMaintenanceRecord): bool
    {
        return $user->hasPermission('destroy-infrastructure-assetmaintenancerecord');
    }
}
