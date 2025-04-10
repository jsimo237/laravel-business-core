<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;


class UserHasOrganization extends Model {

    protected $table = "security_mgt__users_has_organizations";


    //RELATIONS

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(BcUser::class,"user_id");
    }

    /**
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->BelongsTo(BcOrganization::class,"organization_id");
    }



    //FUNCTIONS


}
