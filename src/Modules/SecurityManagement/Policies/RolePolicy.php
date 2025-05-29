<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Kirago\BusinessCore\Modules\SecurityManagement\Constants\BcPermissions;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole;

class RolePolicy {

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return $user->can(BcPermissions::ROLE_VIEW_ANY->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, BcRole $role): bool {
        return $user->canAccessModelWithPermission($role,BcPermissions::ROLE_VIEW->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool {
        return $user->can(BcPermissions::ROLE_CREATE->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, BcRole $role): bool {
        return $user->canAccessModelWithPermission($role,BcPermissions::ROLE_UPDATE->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, BcRole $role): bool  {
        return $user->canAccessModelWithPermission($role,BcPermissions::ROLE_DELETE->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, BcRole $role): bool {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, BcRole $role): bool {
        return true;
    }
}
