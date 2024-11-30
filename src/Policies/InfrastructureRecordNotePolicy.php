<?php

namespace Module\Infrastructure\Policies;

use Module\System\Models\SystemUser;
use Module\Infrastructure\Models\InfrastructureRecordNote;
use Illuminate\Auth\Access\Response;

class InfrastructureRecordNotePolicy
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
        return $user->hasPermission('view-infrastructure-record-note');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, InfrastructureRecordNote $infrastructureRecordNote): bool
    {
        return $user->hasPermission('show-infrastructure-record-note');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-infrastructure-record-note');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, InfrastructureRecordNote $infrastructureRecordNote): bool
    {
        return $user->hasPermission('update-infrastructure-record-note');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, InfrastructureRecordNote $infrastructureRecordNote): bool
    {
        return $user->hasPermission('delete-infrastructure-record-note');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, InfrastructureRecordNote $infrastructureRecordNote): bool
    {
        return $user->hasPermission('restore-infrastructure-record-note');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, InfrastructureRecordNote $infrastructureRecordNote): bool
    {
        return $user->hasPermission('destroy-infrastructure-record-note');
    }
}
