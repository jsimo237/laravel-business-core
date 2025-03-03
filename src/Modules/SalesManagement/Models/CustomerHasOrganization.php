<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;


class CustomerHasOrganization extends Model {

    protected string $table = "sales_mgt__customers_has_organizations";


    //RELATIONS

    /**
     * @return BelongsTo
     */
    public function customer(){
        return $this->BelongsTo(Customer::class,"customer_id");
    }

    /**
     * @return BelongsTo
     */
    public function organization(){
        return $this->BelongsTo(Organization::class,"organization_id");
    }



    //FUNCTIONS


}
