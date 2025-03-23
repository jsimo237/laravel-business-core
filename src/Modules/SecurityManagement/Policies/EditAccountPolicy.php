<?php

namespace App\Policies;

use App\Models\SecurityManagement\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

class EditAccountPolicy{
    use HandlesAuthorization;

    /** Autorise la modification des infos du compte connecté
     * @param Authenticatable $user
     * @param Admin|Donator $model
     * @return bool
     */
    public function editAccount(Authenticatable $user,$model){
        return $model->is($user);
    }
}
