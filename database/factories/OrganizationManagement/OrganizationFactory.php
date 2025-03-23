<?php

namespace Kirago\BusinessCore\Database\Factories\OrganizationManagement;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;

/**
 * @extends Factory
 */
class OrganizationFactory extends Factory{

    protected $model = BcOrganization::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array{
        return [
            'name' => $this->faker->company(),
            'email' => $this->faker->unique()->companyEmail,
            'description' => $this->faker->paragraph,
        ];
    }
}
