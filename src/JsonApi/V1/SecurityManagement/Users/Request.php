<?php

namespace Kirago\BusinessCore\JsonApi\V1\SecurityManagement\Users;

use Illuminate\Validation\Rule;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class Request extends ResourceRequest {

    public function authorize(): bool{
        return true; // Autoriser toutes les requêtes
    }

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        /**
         * @var User|null $model
         */
        $model = $this->model();

       $organization = currentOrganization();
       $tableName = (new User)->getTable();

        $uniqueEmail = Rule::unique($tableName, 'email')
                        ->where("organization_id",$organization->getKey())
                        ->when(filled($model),fn($q)=> $q->ignoreModel($model));

        $uniqueUsername = Rule::unique($tableName, 'username')
                            ->where("organization_id",$organization->getKey())
                            ->when(filled($model),fn($q)=> $q->ignoreModel($model));


        $uniquePhone = Rule::unique($tableName, 'phone')
                                ->where("organization_id",$organization->getKey())
                                ->when(filled($model),fn($q)=> $q->ignoreModel($model));

        return [
            'firstname' => ['required', 'string',"min:4",'max:60'],
            'lastname'  => ['nullable', 'string',"min:4",'max:60'],
            'username'  => ['nullable','string',$uniqueUsername,'max:255'],
            'email'     => ['required', 'string',$uniqueEmail,'max:255'],
            'phone'     => ['nullable', 'numeric',$uniquePhone],
            'is_active' => ['nullable', 'boolean'],
            'is_2fa_enabled' => ['nullable', 'boolean'],

           // 'publishedAt' => ['nullable', JsonApiRule::dateTime()],

            //'topic_format_code' => JsonApiRule::toOne(),
        ];
    }

}
