<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

trait HasUser
{


    public static function bootHasUser(){

    }


    public function user(): MorphOne
    {
        return $this->morphOne(
                    BcUser::class,
                    BcUser::MORPH_FUNCTION_NAME,
                    BcUser::MORPH_ID_COLUMN,
                    BcUser::MORPH_TYPE_COLUMN,
                );
    }

    public function getUser(): ?BcUser
    {
        return $this->user;
    }

    //
    public static function getAuthPasswordField(): ?string
    {
        return "password";
    }

}