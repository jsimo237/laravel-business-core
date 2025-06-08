<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

class UserRepository
{

    /**
     * @throws ValidationException
     */
    public function updatePassword(User $user, string $oldPassword , string $newPassword) : bool{

        $passwordField = $user->getPasswordField();

        if (!Hash::check($oldPassword,$user->$passwordField)){
            throw ValidationException::withMessages([
                'old_password' => "Mot de passe Incorrect"
            ]);
        }

        $user->$passwordField = $newPassword;
        $user->save();

        return true;
    }

    public function updatePersonnalInformations(User $user, array $payload) : User{

        $user->firstname = $payload['firstname'];
        $user->lastname = $payload['lastname'];
        $user->email = $payload['email'];
        $user->phone = $payload['phone'];
        $user->username = $payload['username'];

        if (isset($payload['old_password']) && isset($payload['new_password'])){
            $this->updatePassword(
                $user,
                $payload['old_password'],
                $payload['new_password']
            );
        }

        $user->save();
        $user->refresh();

        return $user;
    }

}