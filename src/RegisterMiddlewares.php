<?php

namespace Kirago\BusinessCore;

use Illuminate\Foundation\Configuration\Middleware as MiddlewareConfig;
use Kirago\BusinessCore\Modules\SecurityManagement\Middlewares\EnsureAuthGuardHeaderIsPresent;

trait RegisterMiddlewares
{


    /**
     * Pour Laravel 9/10 : Middleware registration classique.
     */
    public function bootWithMiddlewares(){

        // Vérifie si la méthode classique est disponible (Laravel < 11)
        if (method_exists($this->app['router'], 'aliasMiddleware')) {
            $this->app['router']->aliasMiddleware(
                'has-auth-guard-header',
                EnsureAuthGuardHeaderIsPresent::class
            );
        }
    }
}