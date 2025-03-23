<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Interfaces;

use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcSubscription;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property BcSubscription[] $subscriptions
 */
interface HasSubscriptions
{

    public function subscriptions() : MorphMany;
}