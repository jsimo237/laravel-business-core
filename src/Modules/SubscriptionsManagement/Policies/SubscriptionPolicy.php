<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Policies;

use Kirago\BusinessCore\Modules\SecurityManagement\Constants\BcPermissions;

use Illuminate\Contracts\Auth\Authenticatable as User;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcSubscription;

class SubscriptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return $user->can(BcPermissions::SUBSCRIPTION_VIEW_ANY->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, BcSubscription $model): bool {
        return $user->canAccessModelWithPermission($model,BcPermissions::SUBSCRIPTION_VIEW->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool {
        return $user->can(BcPermissions::SUBSCRIPTION_CREATE->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, BcSubscription $model): bool {
        return $user->canAccessModelWithPermission($model,BcPermissions::SUBSCRIPTION_UPDATE->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, BcSubscription $model): bool  {
        return $user->canAccessModelWithPermission($model,BcPermissions::SUBSCRIPTION_DELETE->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, BcSubscription $model): bool {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, BcSubscription $model): bool {
        return true;
    }
}