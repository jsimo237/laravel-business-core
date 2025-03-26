<?php

namespace App\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

class EditAccountPolicy{
    use HandlesAuthorization;

    /** Autorise la modification des infos du compte connecté
     * @param Authenticatable $authenticatable
     * @param BcUser $user
     * @return bool
     */
    public function editAccount(Authenticatable $authenticatable,BcUser $user){
        return $user->is($authenticatable);
    }
}
