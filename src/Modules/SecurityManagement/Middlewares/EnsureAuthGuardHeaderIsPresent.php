<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Support\Constants\ReasonCode;
use Kirago\BusinessCore\Support\Constants\ServerStatus;
use Kirago\BusinessCore\Support\Exceptions\FieldHeaderRequiredException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EnsureAuthGuardHeaderIsPresent
{

    public function handle(Request $request, Closure $next)
    {

        throw_if(
            !$request->hasHeader("x-auth-guard"),
            new FieldHeaderRequiredException(
                ReasonCode::REQUIRED_X_AUTH_GUARD_HEADER->value,
                ServerStatus::BAD_REQUEST_HEADER->value,
            )
        );

        $guardName = $request->header('x-auth-guard');
        $guards = array_keys(config("business-core.authenticables") ?? []);

        throw_if(
            filled($guards) && !in_array($guardName, $guards),
            new \InvalidArgumentException(ReasonCode::INVALID_AUTH_GUARD->value,)
        );


        return $next($request);
    }
}