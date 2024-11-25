<?php

namespace Module\Infrastructure\Policies;

use Module\System\Models\SystemUser;
use Module\Infrastructure\Models\InfrastructureDocumentBpkb;
use Illuminate\Auth\Access\Response;

class InfrastructureDocumentBpkbPolicy
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
        return $user->hasPermission('view-infrastructure-documentbpkb');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(SystemUser $user, InfrastructureDocumentBpkb $infrastructureDocumentBpkb): bool
    {
        return $user->hasPermission('show-infrastructure-documentbpkb');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SystemUser $user): bool
    {
        return $user->hasPermission('create-infrastructure-documentbpkb');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SystemUser $user, InfrastructureDocumentBpkb $infrastructureDocumentBpkb): bool
    {
        return $user->hasPermission('update-infrastructure-documentbpkb');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SystemUser $user, InfrastructureDocumentBpkb $infrastructureDocumentBpkb): bool
    {
        return $user->hasPermission('delete-infrastructure-documentbpkb');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SystemUser $user, InfrastructureDocumentBpkb $infrastructureDocumentBpkb): bool
    {
        return $user->hasPermission('restore-infrastructure-documentbpkb');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(SystemUser $user, InfrastructureDocumentBpkb $infrastructureDocumentBpkb): bool
    {
        return $user->hasPermission('destroy-infrastructure-documentbpkb');
    }
}
