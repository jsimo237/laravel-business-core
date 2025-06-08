<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property BaseOrderContract[] orders
 * @property OrderItemContract[] orderItems
 * @property BaseOrderContract|null order
 * @property OrderItemContract|null orderItem
 */
interface Orderable
{

    public function getOrder(): ?BaseOrderContract;

    public function getOrderItem(): ?OrderItemContract;

    public function order() : HasOneThrough;

    public function orderItem() : MorphOne;

    public function orders() : HasManyThrough;

    public function orderItems() : MorphMany;
}