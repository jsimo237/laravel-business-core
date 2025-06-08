<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Kirago\BusinessCore\Modules\SecurityManagement\Constants\Permissions;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;

class RolePolicy {

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return $user->can(Permissions::ROLE_VIEW_ANY->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Role $role): bool {
        return $user->canAccessModelWithPermission($role,Permissions::ROLE_VIEW->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool {
        return $user->can(Permissions::ROLE_CREATE->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Role $role): bool {
        return $user->canAccessModelWithPermission($role,Permissions::ROLE_UPDATE->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Role $role): bool  {
        return $user->canAccessModelWithPermission($role,Permissions::ROLE_DELETE->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, Role $role): bool {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, Role $role): bool {
        return true;
    }
}
