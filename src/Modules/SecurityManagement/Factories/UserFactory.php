<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Kirago\BusinessCore\Modules\SecurityManagement\Interfaces\AuthenticatableModelContract;
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
    public function definition() : array{
        return [
            'firstname'             => $this->faker->firstName,
            'lastname'              => $this->faker->lastName,
            'username'              => $this->faker->unique()->userName,
            'email'                 => $this->faker->unique()->safeEmail(),
            'phone'                 =>$this->faker->unique()->phoneNumber(),
            'password'              => "000000",
            'remember_token'        => Str::random(10),
            'email_verified_at'     => now(),
            'phone_verified_at'     => now(),
            User::MORPH_ID_COLUMN => null, // Sera défini dynamiquement
            User::MORPH_TYPE_COLUMN => null, // Sera défini dynamiquement
        ];
    }

    public function forModel(AuthenticatableModelContract $authenticable)
    {
        return $this->state(fn (array $attributes) => [
                        User::MORPH_ID_COLUMN => $authenticable->getKey(),
                        User::MORPH_TYPE_COLUMN => $authenticable->getMorphClass(),
                    ]);
    }



    public function configure(): self{

        return $this->afterCreating(function (User $user){

                    })
                    ->afterMaking(function (User $user) {
                        //
                    })
                    ;
    }
}
