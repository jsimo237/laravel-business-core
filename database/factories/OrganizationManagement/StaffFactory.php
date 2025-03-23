<?php

namespace Kirago\BusinessCore\Database\Factories\OrganizationManagement;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff;

/**
 * @extends Factory
 */
class StaffFactory extends Factory{

    protected $model = BcStaff::class;
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
            'email_verified_at'     => now(),
            'phone_verified_at'     => now(),
        ];
    }


    public function configure(): self{

        return $this->afterCreating(function (BcStaff $staff){

        })
//        ->afterMaking(function (Application $wallet) {
//            //
//        })
            ;
    }
}
