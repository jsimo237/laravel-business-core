<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\ContainItemsContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\HasRecipient;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;
use Kirago\BusinessCore\Support\Contracts\GenerateUniqueValueContrat;

/**
 * @property string $code
 * @property Carbon $expiration_time
 * @property string $note
 * @property string $status
 * @property array<string, mixed> $discounts
 * @property Collection $items
 * @property string $invoicing_status
 * @property string $delivery_status
 * @property string $invoicing_type
 */
abstract class BaseOrder extends BaseModel implements
    EventNotifiableContract,GenerateUniqueValueContrat,
    ContainItemsContrat,BaseOrderContract,HasRecipient
{


    const INVOICING_TYPE_PRODUCT = 'PRODUCT';

    const INVOICING_TYPE_AMOUNT = 'AMOUNT';

    protected static function booted()
    {
        static::creating(function (self $order) {
            $order->generateUniqueValue();
        });

        static::saving(function (self $order) {
            $order->refreshOrder();
        });
    }

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