<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class RecaptchaVerifyController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @return mixed
     */
    public function __invoke()
    {
        $recaptchaToken = request()->input('token');

        Log::info($recaptchaToken);
        $client = new Client(['verify' => false]);

        // Effectuer la requête GET avec Guzzle
        $response = $client->request('GET', 'https://www.google.com/recaptcha/api/siteverify', [
                        'query' => [
                            'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
                            'response' => $recaptchaToken,
                        ],
        ]);
        $responseData = json_decode($response->getBody(), true);
        if ($responseData['success']) {
            return response()->json(['success' => true, 'message' => __('notifications.reCAPTCHA_validated_successfully', [])], 200);
        } else {
            return response()->json(['success' => false, 'message' => __('notifications.reCAPTCHA_validation_failed', [])], 400);
        }
    }
}
