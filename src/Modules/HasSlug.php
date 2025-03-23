<?php

namespace Kirago\BusinessCore\Modules;

trait HasSlug
{

    public static function findBySlug($sulg) : string{
        return static::firstWhere('slug',$sulg);
    }
}