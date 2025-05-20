<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcSubscription;

/**
 * @extends Factory
 */
class SubscriptionFactory extends Factory
{

    protected $model = BcSubscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
