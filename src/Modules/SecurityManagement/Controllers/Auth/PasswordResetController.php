<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Modules\SecurityManagement\Events\OtpCodeGenerated;
use Kirago\BusinessCore\Modules\SecurityManagement\Helpers\OtpCodeHelper;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\OtpCode;
use Kirago\BusinessCore\Modules\SecurityManagement\Rules\ValidUserIdentifier;
use Kirago\BusinessCore\Modules\SecurityManagement\Services\AuthService;
use Kirago\BusinessCore\Support\Constants\ReasonCode;

class PasswordResetController extends Controller
{


    /**
     * @throws Exception
     */
    public function request(Request $request)
    {
        $request->validate([
            'identifier' => ['required','string',new ValidUserIdentifier()],
        ]);

        $authService = new AuthService($request->header('x-auth-guard'));
        $user = $authService->findUserByIdentifier($request->input('identifier'));

        throw_if(
            blank($user) ,
            new ModelNotFoundException(
                ReasonCode::USER_NOT_FOUND->value
            )
        );

        $otp = OtpCodeHelper::generateFor($user); // 30min

        // Dispatch mail
        event(new OtpCodeGenerated($otp, 'Votre code de réinitialisation'));

        return response()->json(['message' => 'OTP envoyé avec succès.']);
    }

    public function reset(Request $request): JsonResponse
    {
        $request->validate([
            'identifier' => ['required',"string",new ValidUserIdentifier],
            'code' => ['required', 'string' , Rule::exists((new OtpCode)->getTable())],
            'password'   => ['required',"string","confirmed",Password::defaults()],
        ]);

        $authService = new AuthService($request->header('x-auth-guard'));

        $user = $authService->findUserByIdentifier($request->input('identifier'));

        $isValid = OtpCodeHelper::verify($user, $request->input('code'));

        throw_if(
            !$isValid ,
            ValidationException::withMessages(
                ['code' => 'Code OTP invalide ou expiré.']
            )
        );

        $passwordField = $authService->getModelClass()::getAuthPasswordField();
        $user->$passwordField = $request->input('password');
        $user->save();

        // Supprimer tous les OTP actifs pour ce modèle
        OtpCodeHelper::generateFor($user, 1); // réécriture avec un TTL immédiat pour invalider l'ancien

        return response()->json(['message' => 'Mot de passe réinitialisé avec succès.']);
    }


}
