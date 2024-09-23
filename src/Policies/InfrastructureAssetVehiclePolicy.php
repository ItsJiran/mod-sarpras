<?php

namespace Module\Infrastructure\Policies;

use Module\System\Models\SystemUser;
use Module\Infrastructure\Models\InfrastructureAssetVehicle;
use Illuminate\Auth\Access\Response;

class InfrastructureAssetVehiclePolicy
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
        return $user->hasPermission('view-infrastructure-assetvehicle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, InfrastructureAssetVehicle $infrastructureAssetVehicle): bool
    {
        return $user->hasPermission('show-infrastructure-assetvehicle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-infrastructure-assetvehicle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, InfrastructureAssetVehicle $infrastructureAssetVehicle): bool
    {
        return $user->hasPermission('update-infrastructure-assetvehicle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, InfrastructureAssetVehicle $infrastructureAssetVehicle): bool
    {
        return $user->hasPermission('delete-infrastructure-assetvehicle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, InfrastructureAssetVehicle $infrastructureAssetVehicle): bool
    {
        return $user->hasPermission('restore-infrastructure-assetvehicle');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, InfrastructureAssetVehicle $infrastructureAssetVehicle): bool
    {
        return $user->hasPermission('destroy-infrastructure-assetvehicle');
    }
}
