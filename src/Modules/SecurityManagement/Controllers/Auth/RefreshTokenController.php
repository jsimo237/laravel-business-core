<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class RefreshTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $refreshToken = $request->bearerToken(); // Le client envoie le refresh token

        $token = PersonalAccessToken::findToken($refreshToken);

        if (!$token || !$token->can('refresh')) {
            return response()->json(
                [
                    'message' => 'Invalid refresh token'
                ],
                401 );
        }

        $user = $token->tokenable;

        // Supprimer l’ancien access token si besoin
        $user->tokens()->where('name', 'access-token')->delete();

        // Générer un nouveau access token
        $newAccessToken = $user->createToken('access-token', ['*'])->plainTextToken;


        return response()->json([
            "success" => true,
            "message" => 'Successfull Logged out',
        ]);
    }

}
