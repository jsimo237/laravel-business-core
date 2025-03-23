<?php

namespace Kirago\BusinessCore\Database\Factories\SubscriptionsManagement;


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
            //
        ];
    }
}
