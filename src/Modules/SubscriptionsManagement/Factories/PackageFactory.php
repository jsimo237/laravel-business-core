<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPackage;

/**
 * @extends Factory
 */
class PackageFactory extends Factory
{
    protected $model = BcPackage::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                  => $this->faker->text(30),
            'count_days'            => $this->faker->randomNumber(3),
            'frequency'             => null,
            'price'                 => null,
            'description'           => $this->faker->paragraph,
            'plan_id'               => null,
        ];
    }
}
