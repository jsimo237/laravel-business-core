<?php


namespace Kirago\BusinessCore\Modules\SecurityManagement\Models\Traits;


use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

trait HasAutors{

    public function createdBy(){
        return $this->belongsTo(BcUser::class,"created_by");
    }
    public function updatedBy(){
        return $this->belongsTo(BcUser::class,"updated_by");
    }
}
