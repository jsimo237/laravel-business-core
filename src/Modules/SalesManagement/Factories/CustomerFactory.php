<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BaseBcCustomer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcCustomer;

/**
 * @extends Factory
 */
class CustomerFactory extends Factory{

    protected $model = BcCustomer::class;
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
        ];
    }


    public function configure(): self{

        return $this->afterCreating(function (BaseBcCustomer $customer){

        })
//        ->afterMaking(function (Application $wallet) {
//            //
//        })
            ;
    }
}
