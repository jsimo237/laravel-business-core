<?php

namespace Kirago\BusinessCore\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void discoverRoutes(?string $prefix = null)
 * @method static void discoverApiRoutes(?string $prefix = null)
 * @method static void discoverWebRoutes(?string $prefix = null)
 */
class BusinessCore extends Facade
{

    protected static function getFacadeAccessor()
    {
        return \Kirago\BusinessCore\BusinessCoreManager::class;
    }
}