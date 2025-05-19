<?php

namespace Kirago\BusinessCore\JsonApi\V1\SalesManagement\Orders;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

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
        $topic = $this->model();
       // $uniqueSlug = Rule::unique('posts', 'slug');

        if ($topic) {
           // $uniqueSlug->ignoreModel($topic);
        }

        return [

        ];
    }

}
