<?php

namespace Kirago\BusinessCore\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void discover()
 * @method static void discoverApi()
 * @method static void discoverWeb()
 */
class BcRoute extends Facade
{

    protected static function getFacadeAccessor()
    {
        return \Kirago\BusinessCore\BcRouteManager::class;
    }
}