<?php


namespace Kirago\BusinessCore\Modules\SecurityManagement\Models\Traits;


use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

trait UserInteractWithSomeEntity{


    public static function bootUserInteractWithSomeEntity(){
        static::saved(function (self $user) {

            $user->entity?->update([
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'phone' => $user->phone,
                'country' => $user->country,
                'state' => $user->state,
                'city' => $user->city,
                'zipcode' => $user->zipcode,
                'address' => $user->address,
            ]);

            /**
             * Si c'est user du staff et que son email n'est pas vérifié
             */
            if ($user->is_staff and !$user->hasVerifiedEmail()){
                $user->markEmailAsVerified(); // Marquer son email comme "verifié"!
            }

        });
    }

    public function createdBy(){
        return $this->belongsTo(BcUser::class,"created_by");
    }
    public function updatedBy(){
        return $this->belongsTo(BcUser::class,"updated_by");
    }
}
