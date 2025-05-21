<?php

namespace Kirago\BusinessCore\JsonApi\V1\SalesManagement\Customers;

use App\Constants\MembersType;
use App\Models\ProfilesManagement\Member;
use Illuminate\Validation\Rule;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcCustomer;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use function currentOrganization;
use function Kirago\BusinessCore\JsonApi\V1\ProfilesManagement\Members\filled;

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
         * @var BcCustomer|null $model
         */
        $model = $this->model();

        $tableName = (new BcCustomer)->getTable();

       $organization = currentOrganization();
//
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
            'email'     => ['nullable', 'email',$uniqueEmail,'max:255'],
            'username'  => ['nullable','string',$uniqueUsername,'max:255'],
            'phone'     => ['nullable', 'numeric',$uniquePhone],
           // 'publishedAt' => ['nullable', JsonApiRule::dateTime()],

            //'topic_format_code' => JsonApiRule::toOne(),
        ];
    }

}
