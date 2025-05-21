<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPlan;

/**
 * @extends Factory
 */
class PlanFactory extends Factory
{

    protected $model = BcPlan::class;

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
