<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;

use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\OrderItemContract;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\OrderItem;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

trait InteractWithOrdertemsCapacities
{

    public function getOrder(): ?BaseOrderContract
    {
        return $this->order;
    }

    public function getOrderItem(): ?OrderItemContract
    {
        return $this->orderItem;
    }

    public function order(): HasOneThrough
    {
        return $this->hasOneThrough(
                    Order::class,
                    OrderItem::class,
                    OrderItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
                    'id',               // Clé primaire sur Order
                    'id',               // Clé primaire sur Product
                    'order_id'         // Clé étrangère sur OrderItem (vers Order)
                )
                ->where(
                    (new OrderItem)->getTable().".".OrderItem::MORPH_TYPE_COLUMN,
                    (new static)->getMorphClass()
                );
    }

    public function orderItem(): MorphOne
    {
        return $this->morphOne(
                    OrderItem::class,
                    OrderItem::MORPH_FUNCTION_NAME,
                    OrderItem::MORPH_TYPE_COLUMN,
                );
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(
                    Order::class,
                    OrderItem::class,
                    OrderItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
                    'id',               // Clé primaire sur Order
                    'id',               // Clé primaire sur Product
                    'order_id'         // Clé étrangère sur OrderItem (vers Order)
                )
                ->where(
                    (new OrderItem)->getTable().".".OrderItem::MORPH_TYPE_COLUMN,
                    (new static)->getMorphClass()
                );
    }

    public function orderItems(): MorphMany
    {
        return $this->morphMany(
                    OrderItem::class,
                    OrderItem::MORPH_FUNCTION_NAME,
                    OrderItem::MORPH_TYPE_COLUMN,
                );
    }
}