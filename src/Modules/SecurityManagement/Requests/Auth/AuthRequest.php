<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Kirago\BusinessCore\Modules\SecurityManagement\Rules\ValidUserIdentifier;
use Kirago\BusinessCore\Modules\SecurityManagement\Services\AuthService;
use Illuminate\Validation\Rule;


class AuthRequest extends FormRequest
{

    public function authorize(): bool
    {
       // return currentOrganization() && activeGuard();
        return true;
    }

    /**
     * @return array
     */
    public function rules() : array{
        $guards = array_keys(AuthService::getAllAuthenticables());
        return [
            'identifier'  => ['required', 'string',new ValidUserIdentifier()],
            'password'    => ['required', 'string', Password::defaults() ],
            'guard'       => ['nullable', 'string', Rule::in($guards) ],
            'remember'    => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array
     */
    public function attributes() : array{
        return  [
            "identifier" => __("Identifier"),
            "password" => __("Password"),
            "guard" => __("Guard"),
            "remember" => __("Remember Me"),
        ];
    }
}