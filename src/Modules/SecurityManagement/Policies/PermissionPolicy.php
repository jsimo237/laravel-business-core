<?php


use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcPermission;

class PermissionPolicy {

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, BcPermission $permission): bool {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user,BcPermission $permission): bool {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, BcPermission $permission): bool  {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, BcPermission $permission): bool {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, BcPermission $permission): bool {
        return true;
    }
}
