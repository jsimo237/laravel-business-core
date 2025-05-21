<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kirago\BusinessCore\Modules\MediableBcModel;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\RecipientInteractWithOrderAndInvoice;
use Kirago\BusinessCore\Modules\SecurityManagement\Contracts\AuthenticatableModelContract;
use Kirago\BusinessCore\Modules\SecurityManagement\Traits\HasUser;


/**
 * @property int id
 * @property string firstname
 * @property string lastname
 * @property string fullname
 * @property string username
 * @property string email
 * @property string phone
 */
abstract class BaseBcCustomer extends MediableBcModel
    implements AuthenticatableModelContract,
    RecipientInteractWithOrderAndInvoice {

    use HasUser;

    //FUNCTIONS

   /************ Abstract functions ************/
    abstract public static function getAuthIdentifiersFields() : array;
    abstract public static function getAuthPasswordField() : string;
   // abstract public function getGuardName() : string;
    abstract public function guardName() : string;
    abstract public function orders() : MorphMany;
    abstract public function invoices() : MorphMany;


    //
    public function getObjectName(): string
    {
        return $this->fullname;
    }
}
