<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

trait HasUser
{


    public function bootHasUser(){

    }


    public function user(): MorphOne
    {
        return $this->morphOne(User::class, User::MORPH_FUNCTION_NAME);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    //
    public function getAuthPasswordField(): ?string
    {
        return "password";
    }

}