<?php


namespace Kirago\BusinessCore\Modules\SettingManagment\Traits;

use Kirago\BusinessCore\Modules\SettingManagment\StatusChange;

trait HasStatusChanges{

    public function statusChanges(){
        return $this->morphMany(
            StatusChange::class,
            StatusChange::MORPH_FUNCTION_NAME,
            StatusChange::MORPH_TYPE_COLUMN,
            StatusChange::MORPH_ID_COLUMN
        );
    }

}
