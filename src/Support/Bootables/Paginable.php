<?php


namespace Kirago\BusinessCore\Support\Bootables;

trait Paginable{

    public function scopeList($query){
        if(request()->boolean("showed_all")){
            return $query->get();
        }
        return $query->paginate();
    }

}
