<?php

namespace Kirago\BusinessCore\Modules;

trait HasSlug
{

    public static function findBySlug($sulg) : self{
        return self::firstWhere('slug',$sulg);
    }
}