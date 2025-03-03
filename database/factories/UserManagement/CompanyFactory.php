<?php

namespace Kirago\BusinessCore\Database\Factories\UserManagement;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization>
 */
class CompanyFactory extends Factory{

    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(){
        return [
            'name' => fake()->company(),
            'email' => fake()->unique()->companyEmail,
            'description' => fake()->paragraph,
        ];
    }
}
