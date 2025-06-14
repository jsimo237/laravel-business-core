<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\OrderItemContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\Billable;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\ContainItemsContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\HasBillingDetails;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\HasRecipient;
use Kirago\BusinessCore\Modules\SalesManagement\Traits\WithOrderCapacities;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;
use Kirago\BusinessCore\Support\Contracts\GenerateUniqueValueContrat;


/**
* @property string|int id
* @property string status
* @property string code
* @property string note
* @property Invoice invoice
* @property bool has_no_taxes
* @property \Illuminate\Database\Eloquent\Collection payments
* @property OrderItemContract[] items
* @property array<string, mixed> discounts
* @property DateTime expired_at
* @property DateTime processed_at
*/
abstract class BaseOrder extends BaseModel implements
    EventNotifiableContract,GenerateUniqueValueContrat,
    HasBillingDetails,
    ContainItemsContract,BaseOrderContract,HasRecipient
{


    use WithOrderCapacities;

    const INVOICING_TYPE_PRODUCT = 'PRODUCT';

    const INVOICING_TYPE_AMOUNT = 'AMOUNT';


    public function getRelationsMethods(): array
    {
        return [];
    }

    public function getObjectName(): string
    {
        return $this->code;
    }

    /************ Relations ************/

    /**
     * An Order is created by a user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,"user_id");
    }


    /************ Abstract functions ************/
    abstract public function refreshOrder() : void;

    abstract public function items() : HasMany;

    abstract public function invoice() : HasOne;

    abstract public function generateUniqueValue(string $field = "code") : void ;



}