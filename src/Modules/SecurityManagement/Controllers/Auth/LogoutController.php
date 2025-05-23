<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "success" => true,
            "message" => 'Successfull Logged out',
        ]);
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete(); // Révoque tous les tokens

        return response()->json([
            "success" => true,
            "message" => 'Successfull Logged out from all devices',
        ]);
    }
}
