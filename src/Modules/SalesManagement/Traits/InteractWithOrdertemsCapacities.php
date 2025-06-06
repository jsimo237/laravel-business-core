<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;

use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseOrderItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrderItem;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

trait InteractWithOrdertemsCapacities
{

    public function getOrder(): ?BaseOrder
    {
        return $this->order;
    }

    public function getOrderItem(): ?BaseOrderItem
    {
        return $this->orderItem;
    }

    public function order(): HasOneThrough
    {
        return $this->hasOneThrough(
                    BcOrder::class,
                    BcOrderItem::class,
                    BcOrderItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
                    'id',               // Clé primaire sur Order
                    'id',               // Clé primaire sur Product
                    'order_id'         // Clé étrangère sur OrderItem (vers Order)
                )
                ->where(
                    (new BcOrderItem)->getTable().".".BcOrderItem::MORPH_TYPE_COLUMN,
                    (new static)->getMorphClass()
                );
    }

    public function orderItem(): MorphOne
    {
        return $this->morphOne(
                    BcOrderItem::class,
                    BcOrderItem::MORPH_FUNCTION_NAME,
                    BcOrderItem::MORPH_TYPE_COLUMN,
                );
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(
                    BcOrder::class,
                    BcOrderItem::class,
                    BcOrderItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
                    'id',               // Clé primaire sur Order
                    'id',               // Clé primaire sur Product
                    'order_id'         // Clé étrangère sur OrderItem (vers Order)
                )
                ->where(
                    (new BcOrderItem)->getTable().".".BcOrderItem::MORPH_TYPE_COLUMN,
                    (new static)->getMorphClass()
                );
    }

    public function orderItems(): MorphMany
    {
        return $this->morphMany(
                    BcOrderItem::class,
                    BcOrderItem::MORPH_FUNCTION_NAME,
                    BcOrderItem::MORPH_TYPE_COLUMN,
                );
    }
}