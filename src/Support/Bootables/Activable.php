<?php


namespace Kirago\BusinessCore\Support\Bootables;


use Illuminate\Database\Eloquent\Casts\Attribute;

trait Activable{


    public function scopeActive($query , bool $state = true){
        return $query->where('is_active',$state);
    }


    public function isActiveText(){
        return Attribute::make(
                    get: fn () => ($this->is_active) ? 'Oui' : "Non",
                );
    }

    public function isActive(): bool
    {
        return boolval($this->is_active);
    }
}
