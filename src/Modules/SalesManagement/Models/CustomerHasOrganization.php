<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcCustomer;


class CustomerHasOrganization extends Model {

    protected $table = "sales_mgt__customers_has_organizations";


    //RELATIONS

    /**
     * @return BelongsTo
     */
    public function customer(){
        return $this->BelongsTo(BcCustomer::class,"customer_id");
    }

    /**
     * @return BelongsTo
     */
    public function organization(){
        return $this->BelongsTo(BcOrganization::class,"organization_id");
    }



    //FUNCTIONS


}
