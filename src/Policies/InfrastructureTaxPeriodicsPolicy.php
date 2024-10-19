<?php

namespace Module\Infrastructure\Policies;

use Module\System\Models\SystemUser;
use Module\Infrastructure\Models\InfrastructureTaxPeriodics;
use Illuminate\Auth\Access\Response;

class InfrastructureTaxPeriodicsPolicy
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
        return $user->hasPermission('view-infrastructure-taxperiodics');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, InfrastructureTaxPeriodics $infrastructureTaxPeriodics): bool
    {
        return $user->hasPermission('show-infrastructure-taxperiodics');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-infrastructure-taxperiodics');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, InfrastructureTaxPeriodics $infrastructureTaxPeriodics): bool
    {
        return $user->hasPermission('update-infrastructure-taxperiodics');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, InfrastructureTaxPeriodics $infrastructureTaxPeriodics): bool
    {
        return $user->hasPermission('delete-infrastructure-taxperiodics');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, InfrastructureTaxPeriodics $infrastructureTaxPeriodics): bool
    {
        return $user->hasPermission('restore-infrastructure-taxperiodics');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, InfrastructureTaxPeriodics $infrastructureTaxPeriodics): bool
    {
        return $user->hasPermission('destroy-infrastructure-taxperiodics');
    }
}
