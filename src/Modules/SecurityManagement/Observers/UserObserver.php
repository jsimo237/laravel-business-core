<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Observers;

use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

class UserObserver{



    /** Se produit lorsque la resource est créee
     * @param BcUser $user
     * @return void
     */
    public function creating(BcUser $user){
      //  $attributes = $user->getAttributes();

        $isManager = $user->is_manager ?? false;

        if ($isManager){
            $user->setAttribute("manager_id",$user->id);
        }

        if ($isManager) {
            $user->assignRole(BcRole::MANAGER);
        }
    }
}
