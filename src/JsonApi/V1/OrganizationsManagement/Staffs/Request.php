<?php

namespace Kirago\BusinessCore\JsonApi\V1\OrganizationsManagement\Staffs;

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
        $model = $this->getUser();



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
          //  'type'      => ['required', 'string',Rule::in(MembersType::values())],
            'username'  => ['nullable','string',$uniqueUsername,'max:255'],
            'email'     => ['nullable', 'string',$uniqueEmail,'max:255'],
            'phone'     => ['nullable', 'numeric',$uniquePhone],

           // 'publishedAt' => ['nullable', JsonApiRule::dateTime()],

            //'topic_format_code' => JsonApiRule::toOne(),
        ];
    }

}
