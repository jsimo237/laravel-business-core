<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property BaseOrder[] orders
 * @property BaseOrderItem[] orderItems
 * @property BaseOrder|null order
 * @property BaseOrderItem|null orderItem
 */
interface Orderable
{

    public function getOrder(): ?BaseOrder;

    public function getOrderItem(): ?BaseOrderItem;

    public function order() : HasOneThrough;

    public function orderItem() : MorphOne;

    public function orders() : HasManyThrough;

    public function orderItems() : MorphMany;
}