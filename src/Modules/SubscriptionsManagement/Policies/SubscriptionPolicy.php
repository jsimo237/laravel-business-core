<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Policies;

use Kirago\BusinessCore\Modules\SecurityManagement\Constants\Permissions;

use Illuminate\Contracts\Auth\Authenticatable as User;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Subscription;

class SubscriptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return $user->can(Permissions::SUBSCRIPTION_VIEW_ANY->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Subscription $model): bool {
        return $user->canAccessModelWithPermission($model,Permissions::SUBSCRIPTION_VIEW->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool {
        return $user->can(Permissions::SUBSCRIPTION_CREATE->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Subscription $model): bool {
        return $user->canAccessModelWithPermission($model,Permissions::SUBSCRIPTION_UPDATE->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Subscription $model): bool  {
        return $user->canAccessModelWithPermission($model,Permissions::SUBSCRIPTION_DELETE->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, Subscription $model): bool {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, Subscription $model): bool {
        return true;
    }
}