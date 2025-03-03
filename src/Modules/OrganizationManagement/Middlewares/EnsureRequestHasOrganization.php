<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kirago\BusinessCore\Enums\ReasonCode;
use Kirago\BusinessCore\Enums\ServerStatus;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Support\Exceptions\FieldHeaderRequiredException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            new FieldHeaderRequiredException(
                ReasonCode::REQUIRED_X_ORGANIZATION_ID_HEADER->value,
                ServerStatus::BAD_REQUEST_HEADER->value,
            )
        );

        $organizationId = $request->header("x-organization-id");

        $organization = Organization::firstWhere('id', $organizationId);

        throw_if(
            !$organization,
            new ModelNotFoundException(
                ReasonCode::ORGANIZATION_NOT_FOUND->value,
                ServerStatus::NOT_FOUND->value,
            )
        );

        return $next($request);
    }
}