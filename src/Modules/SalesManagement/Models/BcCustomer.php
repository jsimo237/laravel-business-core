<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kirago\BusinessCore\Modules\SalesManagement\Factories\CustomerFactory;
use Kirago\BusinessCore\Modules\SecurityManagement\Contracts\AuthenticatableModelContract;

/**
 * @property int id
 * @property string firstname
 * @property string lastname
 * @property string fullname
 * @property string username
 * @property string email
 * @property string phone
 */
class BcCustomer extends BaseBcCustomer implements AuthenticatableModelContract {

    protected $table = "sales_mgt__customers";

    //RELATIONS

    //FUNCTIONS
    protected static function newFactory(){
        return CustomerFactory::new();
    }

    public static function getAuthIdentifiersFields(): array
    {
        return ["email","username",'phone'];
    }

    public function getGuardName(): string
    {
        return "api";
    }

    //

    public function getObjectName(): string
    {
        return $this->fullname;
    }

    public function orders(): MorphMany
    {
        return $this->morphMany(static::class, 'recipient');
    }

    public function invoices(): MorphMany
    {
        return $this->morphMany(static::class, 'recipient');
    }
}
