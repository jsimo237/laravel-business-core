<?php


namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models\Traits;

use Kirago\BusinessCore\Modules\CoresManagement\Models\Phone;

trait HasAdresses{


    public function adresses(){
        return $this->morphMany(
            Phone::class,
            Phone::MORPH_FUNCTION_NAME,
            Phone::MORPH_TYPE_COLUMN,
            Phone::MORPH_ID_COLUMN
        );
    }

    public function adress(){
        return $this->morphOne(
            Phone::class,
            Phone::MORPH_FUNCTION_NAME,
            Phone::MORPH_TYPE_COLUMN,
            Phone::MORPH_ID_COLUMN
        );
    }
}
