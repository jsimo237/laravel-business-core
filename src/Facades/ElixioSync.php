<?php

namespace Kirago\BusinessCore\Facades;

use Illuminate\Support\Facades\Facade;

class ElixioSync extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'business-core';
    }
}
