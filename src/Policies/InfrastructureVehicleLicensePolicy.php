<?php

namespace Module\Infrastructure\Policies;

use Module\System\Models\SystemUser;
use Module\Infrastructure\Models\InfrastructureVehicleLicense;
use Illuminate\Auth\Access\Response;

class InfrastructureVehicleLicensePolicy
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
        return $user->hasPermission('view-infrastructure-vehiclelicense');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, InfrastructureVehicleLicense $infrastructureVehicleLicense): bool
    {
        return $user->hasPermission('show-infrastructure-vehiclelicense');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-infrastructure-vehiclelicense');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, InfrastructureVehicleLicense $infrastructureVehicleLicense): bool
    {
        return $user->hasPermission('update-infrastructure-vehiclelicense');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, InfrastructureVehicleLicense $infrastructureVehicleLicense): bool
    {
        return $user->hasPermission('delete-infrastructure-vehiclelicense');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, InfrastructureVehicleLicense $infrastructureVehicleLicense): bool
    {
        return $user->hasPermission('restore-infrastructure-vehiclelicense');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, InfrastructureVehicleLicense $infrastructureVehicleLicense): bool
    {
        return $user->hasPermission('destroy-infrastructure-vehiclelicense');
    }
}
