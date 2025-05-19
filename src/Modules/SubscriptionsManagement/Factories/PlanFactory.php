<?php

namespace Kirago\BusinessCore\Database\Factories\SubscriptionsManagement;

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
