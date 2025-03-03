<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Kirago\BusinessCore\Modules\SecurityManagement\Requests\Auth\AuthRequest;
use Kirago\BusinessCore\Modules\SecurityManagement\Services\AuthService;

class LoginController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Tentative d'authentification
     * @param AuthRequest $request
     * @return mixed
     */
    public function login(AuthRequest $request): mixed
    {
        // On instancie le service avec la boone garde
        $authService = new AuthService($request->guard);

        /**
         * @var array
         */
        [$user,$accessToken,$tokenExpiredAt] = $authService->authenticate($request->identifier, $request->password);

        return response()->json([
                    'access_token' => $accessToken,
                    'token_expired_at' => $tokenExpiredAt,
                    'user' => $user
                ]);
    }

}