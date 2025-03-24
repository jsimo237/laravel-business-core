<?php

namespace Kirago\BusinessCore\Database\Factories\SecurityManagement;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Kirago\BusinessCore\Modules\SecurityManagement\Contracts\AuthenticatableModelContract;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

/**
 * @extends Factory
 */
class UserFactory extends Factory{

    protected $model = BcUser::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array{
        return [
            'password' => "000000", // password
            'remember_token' => Str::random(10),
            BcUser::MORPH_ID_COLUMN => null, // Sera défini dynamiquement
            BcUser::MORPH_TYPE_COLUMN => null, // Sera défini dynamiquement
        ];
    }

    public function forModel(AuthenticatableModelContract $authenticable)
    {
        return $this->state(fn (array $attributes) => [
                        BcUser::MORPH_ID_COLUMN => $authenticable->getKey(),
                        BcUser::MORPH_TYPE_COLUMN => $authenticable->getMorphClass(),
                    ]);
    }



    public function configure(): self{

        return $this->afterCreating(function (BcUser $user){

                    })
                    ->afterMaking(function (BcUser $user) {
                        //
                    })
                    ;
    }
}
