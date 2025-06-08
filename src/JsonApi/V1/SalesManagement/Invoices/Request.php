<?php

namespace Kirago\BusinessCore\JsonApi\V1\SalesManagement\Invoices;

use Illuminate\Validation\Rule;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
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
