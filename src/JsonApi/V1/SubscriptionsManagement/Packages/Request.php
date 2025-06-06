<?php

namespace Kirago\BusinessCore\JsonApi\V1\SubscriptionsManagement\Packages;

use Illuminate\Validation\Rule;
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
        $model = $this->model();

        return [

        ];
    }

}
