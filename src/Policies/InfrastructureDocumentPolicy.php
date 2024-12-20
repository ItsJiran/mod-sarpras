<?php

namespace Module\Infrastructure\Policies;

use Module\System\Models\SystemUser;
use Module\Infrastructure\Models\InfrastructureDocument;
use Illuminate\Auth\Access\Response;

class InfrastructureDocumentPolicy
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
        return $user->hasPermission('view-infrastructure-document');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, InfrastructureDocument $infrastructureDocument): bool
    {
        return $user->hasPermission('show-infrastructure-document');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-infrastructure-document');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, InfrastructureDocument $infrastructureDocument): bool
    {
        return $user->hasPermission('update-infrastructure-document');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, InfrastructureDocument $infrastructureDocument): bool
    {
        return $user->hasPermission('delete-infrastructure-document');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, InfrastructureDocument $infrastructureDocument): bool
    {
        return $user->hasPermission('restore-infrastructure-document');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, InfrastructureDocument $infrastructureDocument): bool
    {
        return $user->hasPermission('destroy-infrastructure-document');
    }
}
