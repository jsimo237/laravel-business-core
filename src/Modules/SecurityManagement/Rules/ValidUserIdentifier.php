<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Request;
use Kirago\BusinessCore\Modules\SecurityManagement\Services\AuthService;


class ValidUserIdentifier implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $guard = Request::header('x-auth-guard');
        $authService = new AuthService($guard);
        $user = $authService->findUserByIdentifier($value);

        if (blank($user)) {
           // $fail(ReasonCode::USER_NOT_FOUND->value);
            $fail("User not found.");
        }
    }
}