<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

class MeController extends Controller {

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return DataResponse|JsonResponse
     */
    public function __invoke(Request $request) : DataResponse|JsonResponse {

        /**
         * @var User $user
         */
        $user = $request->user();
        $user = $user->only([
                    "id",
                    "firstname",
                    "lastname",
                    "phone",
                    "fullname",
                    "initials",
                    "username",
                    "email",
                    "email_verified_at",
                    "phone_verified_at",
                    "is_active",
                    "is_2fa_enabled",
                    "created_at",
                    "updated_at",
                    "privileges",
                    "roles",
                ]);

        if ($roles = $user['roles']){
            $user['roles'] = $roles->map->only([
                                    "id",
                                    "name",
                                    "guard_name",
                                    "description",
                                    "editable",
                                    "created_at",
                                    "updated_at",
                                  //  "permissions_ids",
                                ]);
        }

        return response()->json($user);

    }
}
