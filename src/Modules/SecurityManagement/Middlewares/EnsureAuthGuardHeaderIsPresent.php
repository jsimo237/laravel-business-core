<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Support\Constants\BcReasonCode;
use Kirago\BusinessCore\Support\Constants\BcServerStatus;
use Kirago\BusinessCore\Support\Constants\BusinessCoreConfigs;
use Kirago\BusinessCore\Support\Exceptions\BcFieldHeaderRequiredException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EnsureAuthGuardHeaderIsPresent
{

    public function handle(Request $request, Closure $next)
    {

        throw_if(
            !$request->hasHeader("x-auth-guard"),
            new BcFieldHeaderRequiredException(
                BcReasonCode::REQUIRED_X_AUTH_GUARD_HEADER->value,
                BcServerStatus::BAD_REQUEST_HEADER->value,
            )
        );

        $guardName = $request->header('x-auth-guard');
        $guards = array_keys(BusinessCoreConfigs::getAuthenticables() ?? []);

        throw_if(
            filled($guards) && !in_array($guardName, $guards),
            new \InvalidArgumentException(BcReasonCode::INVALID_AUTH_GUARD->value,)
        );


        return $next($request);
    }
}