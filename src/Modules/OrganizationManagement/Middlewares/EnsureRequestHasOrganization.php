<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Middlewares;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Support\Constants\BcServerStatus;
use Kirago\BusinessCore\Support\Constants\ReasonCode;
use Kirago\BusinessCore\Support\Exceptions\BcFieldHeaderRequiredException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EnsureRequestHasOrganization
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string ...$guards
     * @return Response
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        throw_if(
            !$request->hasHeader("x-organization-id"),
            new BcFieldHeaderRequiredException(
                ReasonCode::REQUIRED_X_ORGANIZATION_ID_HEADER->value,
                BcServerStatus::BAD_REQUEST_HEADER->value,
            )
        );

        $organizationId = $request->header("x-organization-id");

        $organization = BcOrganization::firstWhere('id', $organizationId);

        throw_if(
            !$organization,
            new ModelNotFoundException(
                ReasonCode::ORGANIZATION_NOT_FOUND->value,
                BcServerStatus::NOT_FOUND->value,
            )
        );

        return $next($request);
    }
}