<?php

namespace Kirago\BusinessCore\Support\Bootables;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait Personnable
{

    public function __construct(){

        $this->append([
            "fullName",
        ]);
    }


    /**
     * @return Attribute
     */
    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => ucfirst($this->firstname) . ' ' . ucfirst($this->lastname),
        );
    }

}

