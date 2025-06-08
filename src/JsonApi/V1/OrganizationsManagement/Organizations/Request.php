<?php

namespace Kirago\BusinessCore\JsonApi\V1\OrganizationsManagement\Organizations;

use Illuminate\Validation\Rule;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\BillingInformations;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class Request extends ResourceRequest {

    public function authorize(): bool{
        return true;
    }

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        /**
         * @var Organization $model
         */
        $model = $this->model();

        $uniquePhone = Rule::unique($model->getTable(), 'phone')
                        ->when(filled($model),fn($q)=> $q->ignoreModel($model));

        $uniqueEmail = Rule::unique($model->getTable(), 'email')
                         ->when(filled($model),fn($q)=> $q->ignoreModel($model));

        $uniqueSlug = Rule::unique($model->getTable(), 'slug')
                      ->when(filled($model),fn($q)=> $q->ignoreModel($model));


        return [
            'name'        => ['required', 'string', "min:4","max:60"],
            'description' => ['nullable', 'string', "min:4"],
            'slug'        => ['required', 'string', $uniqueSlug],
            'email'       => ['required', 'string', $uniqueEmail,"max:255"],
            'phone'       => ['nullable', 'numeric', $uniquePhone],
            'manager'     => ['nullable', JsonApiRule::toOne()],
            'is_active'   => ['nullable', JsonApiRule::boolean()],

            ...BillingInformations::baseRules(),
        ];
    }

}
