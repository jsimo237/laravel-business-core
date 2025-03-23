<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff;

class StaffPolicy {

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, BcStaff $staff): bool {
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
    public function update(?User $user, BcStaff $staff): bool {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, BcStaff $staff): bool  {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, BcStaff $staff): bool {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, BcStaff $staff): bool {
        return true;
    }
}
