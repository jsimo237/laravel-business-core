<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcOtpCode;

class OtpPolicy {

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, BcOtpCode $otp): bool {
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
    public function update(?User $user, BcOtpCode $otp): bool {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, BcOtpCode $otp): bool  {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, BcOtpCode $otp): bool {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, BcOtpCode $otp): bool {
        return true;
    }
}
