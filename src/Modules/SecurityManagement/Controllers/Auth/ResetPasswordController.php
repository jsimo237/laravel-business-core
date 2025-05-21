<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth;


use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use Throwable;

class ResetPasswordController extends JsonApiController
{



    /**
     * Reset the given user's password.
     * We overwrite this method since we are stateless so the login and rember token
     * are no longer needed after password reset
     * Also we have a mutator on user model that automatically hashes the password
     *
     * @param  User  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = $password;
        $user->save();

        event(new PasswordReset($user));
    }
}
