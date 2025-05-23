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
                        'message' => 'Invalid or unauthorized refresh token'
                    ],
                    401
                );
        }

        $user = $token->tokenable;

        // Révoquer le refresh token utilisé
        $token->delete();
        $accessTokenExpiredAt = now()->addMinutes(config('sanctum.expiration'));

        $abilities            = $user?->privileges ?? $user?->permissions?->pluck("name")->toArray() ?? ["*"];

        // Générer un nouveau access_token et refresh_token
        $newAccessToken = $user->createToken($request->userAgent(), $abilities, $accessTokenExpiredAt);
        $newRefreshToken = $user->createToken('refresh-token', ['refresh'], now()->addDays(30));

        $newAccessToken      = explode('|', $newAccessToken->plainTextToken)[1];
        $newRefreshToken     = explode('|', $newRefreshToken->plainTextToken)[1];

        return response()->json([
                'access_token' => $newAccessToken ,
                'refresh_token' => $newRefreshToken,
                'token_expired_at' => $accessTokenExpiredAt->timestamp,
                'token_type' => 'Bearer',
            ]);
    }

}
