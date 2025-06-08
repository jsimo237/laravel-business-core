<?php


namespace Kirago\BusinessCore\Modules\SecurityManagement\Models\Traits;


use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

trait UserInteractWithSomeEntity{


    public static function bootUserInteractWithSomeEntity(){

        static::saved(function (self $user) {

//            $user->entity?->update([
//                'firstname' => $user->firstname,
//                'lastname' => $user->lastname,
//                'email' => $user->email,
//                'phone' => $user->phone,
////                'country' => $user->country,
////                'state' => $user->state,
////                'city' => $user->city,
////                'zipcode' => $user->zipcode,
////                'address' => $user->address,
//            ]);

            /**
             * Si c'est user du staff et que son email n'est pas vérifié
             */
            if ($user->isStaff() and !$user->hasVerifiedEmail()){
              //  $user->markEmailAsVerified(); // Marquer son email comme "verifié"!
            }

        });
    }

}
