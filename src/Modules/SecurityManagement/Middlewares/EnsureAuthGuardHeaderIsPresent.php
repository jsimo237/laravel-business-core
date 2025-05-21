<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Support\Constants\BusinessCoreConfigs;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EnsureAuthGuardHeaderIsPresent
{

    public function handle(Request $request, Closure $next)
    {
        throw_if(
            !$request->hasHeader('x-auth-guard'),
            new \InvalidArgumentException("Missing required header: x-auth-guard")
        );

        $guardName = $request->header('x-auth-guard');
        $guards = array_keys(BusinessCoreConfigs::getAuthenticables() ?? []);

        throw_if(
            filled($guards) && !in_array($guardName, $guards),
            new \InvalidArgumentException("Invalid guard type: {$guardName}")
        );


        return $next($request);
    }
}