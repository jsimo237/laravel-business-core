<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

trait HasUser
{

    public static function bootHasUser(){

    }


    public function user(): MorphOne
    {
        return $this->morphOne(
                    User::class,
                    User::MORPH_FUNCTION_NAME,
                    User::MORPH_TYPE_COLUMN,
                    User::MORPH_ID_COLUMN,
                );
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    //
    public static function getAuthPasswordField(): string
    {
        return "password";
    }

}