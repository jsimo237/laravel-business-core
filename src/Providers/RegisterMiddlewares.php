<?php

namespace Kirago\BusinessCore\Providers;

use Kirago\BusinessCore\Modules\OrganizationManagement\Middlewares\EnsureRequestHasOrganization;
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

            $this->app['router']->aliasMiddleware(
                'has-organization',
                EnsureRequestHasOrganization::class
            );
        }
    }
}