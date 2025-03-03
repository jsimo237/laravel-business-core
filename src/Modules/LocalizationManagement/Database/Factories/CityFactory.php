<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\City;

/**
 * @extends Factory
 */
class CityFactory extends Factory{

    protected string $model = City::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(){
        return [
            //
        ];
    }
}
