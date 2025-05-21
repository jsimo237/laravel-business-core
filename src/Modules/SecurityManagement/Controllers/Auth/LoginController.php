<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Kirago\BusinessCore\Modules\SecurityManagement\Requests\Auth\AuthRequest;
use Kirago\BusinessCore\Modules\SecurityManagement\Services\AuthService;

class LoginController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Tentative d'authentification
     * @param AuthRequest $request
     * @throws ValidationException
     */
    public function login(AuthRequest $request): JsonResponse
    {
        // On instancie le service avec la bonne garde
        $authService = new AuthService($request->header("x-auth-guard"));

        /**
         * @var array
         */
        [$user,$accessToken,$tokenExpiredAt] = $authService->authenticate($request->identifier, $request->password);

        return response()->json([
                    'access_token' => $accessToken,
                    'token_expired_at' => Carbon::parse($tokenExpiredAt)->timestamp,
                    'token_type' => 'Bearer',
                ]);
    }

}
