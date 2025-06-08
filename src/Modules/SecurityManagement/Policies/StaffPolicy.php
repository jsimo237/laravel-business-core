<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Policies;

use Illuminate\Contracts\Auth\Authenticatable as User;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;
use Kirago\BusinessCore\Modules\SecurityManagement\Constants\Permissions;

class StaffPolicy {

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return $user->can(Permissions::STAFF_VIEW_ANY->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Staff $staff): bool {
        return $user->canAccessModelWithPermission($staff,Permissions::STAFF_VIEW->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool {
        return $user->can(Permissions::STAFF_CREATE->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Staff $staff): bool {
        return $user->canAccessModelWithPermission($staff,Permissions::STAFF_UPDATE->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Staff $staff): bool  {
        return $user->canAccessModelWithPermission($staff,Permissions::STAFF_DELETE->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, Staff $staff): bool {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, Staff $staff): bool {
        return true;
    }
}
