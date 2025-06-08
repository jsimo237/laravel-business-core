<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Interfaces;

use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property Subscription[] $subscriptions
 */
interface HasSubscriptions
{

    public function subscriptions() : MorphMany;
}