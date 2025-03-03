<?php

namespace Kirago\BusinessCore\Database\Factories\UserManagement;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

/**
 * @extends Factory
 */
class UserFactory extends Factory{

    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(){
        return [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'username' => fake()->unique()->userName,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt("123456"), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function manager() {
        return $this->state(fn (array $attributes) => [
            'is_manager' => true,
        ]);
    }

    public function configure(): UserFactory{

        return $this->afterCreating(function (User $user){

        })
//        ->afterMaking(function (Application $wallet) {
//            //
//        })
            ;
    }
}
