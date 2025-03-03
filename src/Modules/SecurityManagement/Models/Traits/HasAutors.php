<?php


namespace Kirago\BusinessCore\Modules\SecurityManagement\Models\Traits;


use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

trait HasAutors{

    public function createdBy(){
        return $this->belongsTo(User::class,"created_by");
    }
    public function updatedBy(){
        return $this->belongsTo(User::class,"updated_by");
    }
}
