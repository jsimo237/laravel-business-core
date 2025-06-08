<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth;


use Illuminate\Routing\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kirago\BusinessCore\Modules\SecurityManagement\Events\OtpCodeGenerated;
use Kirago\BusinessCore\Modules\SecurityManagement\Helpers\OtpCodeHelper;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\OtpCode;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use Kirago\BusinessCore\Modules\SecurityManagement\Services\AuthService;
use Kirago\BusinessCore\Support\Constants\ReasonCode;

class OtpCodeController extends Controller
{

    /**
     * @throws ValidationException
     */
    public function verify(Request $request) : JsonResponse{

        $request->validate([
                    'identifier' => ['required',"string"],
                    'code' => ['required', 'string' , Rule::exists((new OtpCode)->getTable())],
                ]);

        $authService = new AuthService($request->header('x-auth-guard'));

        $user = $authService->findUserByIdentifier($request->input('identifier'));

        throw_if(
            blank($user) ,
            new ModelNotFoundException(
                ReasonCode::USER_NOT_FOUND->value
            )
        );

        $isValid = OtpCodeHelper::verify($user, $request->input('code'));

        throw_if(
            !$isValid ,
            ValidationException::withMessages(
                ['code' => 'Code OTP invalide ou expiré.']
            )
        );

        $user->markEmailAsVerified();

        return response()->json([
            'message' => 'Code OTP validé avec succès.',
        ]);

    }

    /**
     * Renvoie un nouveau code OTP pour un utilisateur spécifique.
     *
     * Cette méthode génère un nouveau code OTP pour l'utilisateur donné et
     * envoie un événement de génération de code OTP.
     *
     * @param Request $request
     * @return JsonResponse La réponse JSON contenant un message de succès ou d'échec.
     * @throws ValidationException
     * @throws Exception
     */
    public function resend(Request $request) : JsonResponse{

        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'string' , Rule::exists((new User)->getTable(),"email")],
            ]
        );

        $validated = $validator->validate();

        /**
         * @var User $user
         */
        $user = User::firstWhere('email', $validated['email']);

        // Génère un nouveau code OTP pour l'utilisateur
        $otp = OtpCodeHelper::generateFor($user);

        event(new OtpCodeGenerated($otp,__("Verification Email")));

        return response()->json([
            'message' => __("Un nouveau code OTP a été envoyé à votre adresse email."),
        ]);

    }


}
