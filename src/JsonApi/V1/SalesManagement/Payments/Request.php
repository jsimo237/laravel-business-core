<?php

namespace Kirago\BusinessCore\JsonApi\V1\SalesManagement\Payments;

use Illuminate\Validation\Rule;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\PaymentSource;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

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
        $model = $this->model();

        return [
            'firstname' => ['required', 'string',"min:4",'max:60'],
            'source_code'      => ['required', 'string',Rule::in(PaymentSource::values())],
            'source_reference'  => ['nullable', 'string',"min:4",'max:255'],
            'source_response'  => ['nullable'],
            'amount'     => ['required'],
            'note'     => ['nullable',],
            'paid_at'     => ['nullable',"date"],
        ];
    }

}
