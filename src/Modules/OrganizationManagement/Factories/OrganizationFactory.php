<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;

/**
 * @extends Factory
 */
class OrganizationFactory extends Factory{

    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array{
        return [
            'name'             => $this->faker->unique()->company,
            'description'      => $this->faker->paragraph,
            'slug'              => $this->faker->unique()->slug,
            'email'                 => $this->faker->unique()->companyEmail,
            'phone'                 => $this->faker->unique()->phoneNumber(),
        ];
    }
}
