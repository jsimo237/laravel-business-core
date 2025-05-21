<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth;

use App\Http\Requests\Api\V1\Auth\ForgotPasswordRequest;
use CloudCreativity\LaravelJsonApi\Document\Error\Error;
use CloudCreativity\LaravelJsonApi\Http\Controllers\JsonApiController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Throwable;

class ForgotPasswordController extends JsonApiController
{
    use SendsPasswordResetEmails;

    /**
     * Handle the incoming request.
     * We overwrite this method to enable correct json:api response
     *
     * @return JsonResponse|mixed
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        try {
            $response = Password::sendResetLink($request->only('email'));

            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return response()->json([], 204);
                case Password::INVALID_USER:
                    return $this->reply()->errors([
                        Error::fromArray([
                            'title' => 'Bad Request',
                            'detail' => trans($response),
                            'status' => '400',
                            'source' => [
                                'pointer' => '/data/attributes/email',
                            ],
                            'meta' => [
                                'failed' => [
                                    'rule' => 'exists',
                                ],
                            ],
                        ]),
                    ]);
            }
        } catch (Throwable $ex) {
            // dd('catch');
            return $this->reply()->errors([
                Error::fromArray([
                    'title' => 'Bad Request',
                    'detail' => $ex->getMessage(),
                    'status' => '400',
                ]),
            ]);
        }
    }
}
