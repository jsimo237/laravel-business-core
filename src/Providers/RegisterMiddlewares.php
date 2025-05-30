<?php

namespace Kirago\BusinessCore\Providers;

use Kirago\BusinessCore\Modules\OrganizationManagement\Middlewares\EnsureRequestHasOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Middlewares\EnsureAuthGuardHeaderIsPresent;

trait RegisterMiddlewares
{

    /**
     * Pour Laravel 9/10+ : Middleware registration classique.
     */
    public function bootWithMiddlewares(){

        /**
         * Vérifie si on peut enregistrer des alias de middleware (Laravel < 11)
         */

        $middlewares = config('business-core.middlewares', []);

        if ($middlewares && method_exists($this->app['router'], 'aliasMiddleware')) {
            foreach ($middlewares as $alias => $middleware) {
                if (class_exists($middleware)) {
                    $this->app['router']->aliasMiddleware($alias, $middleware);
                }
            }
        }

    }
}