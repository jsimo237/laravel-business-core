<?php

namespace Kirago\BusinessCore\JsonApi\V1\SalesManagement\Products;

use Illuminate\Validation\Rule;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Product;
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
         * @var Product|null $model
         */
        $model = $this->model();
       $organization = currentOrganization();
//
        $uniqueSku = Rule::unique((new Product)->getTable(), 'sku')
                        ->when($organization,fn($q)=> $q->where("organization_id",$organization->getKey()))
                        ->when(filled($model),fn($q)=> $q->ignoreModel($model));


        return [
              'name'               => ['required', 'string',"min:2",'max:255'],
              'description'        => ['nullable', 'string',"min:2"],
              'buying_price'       => ['required', 'numeric'],
              'selling_price'      => ['required', 'numeric'],
              'buying_taxes'       => ['nullable', 'array'],
              'selling_taxes'      => ['nullable', 'array'],
              'can_be_sold'        => ['nullable', 'boolean'],
              'can_be_purchased'   => ['nullable', 'boolean'],
              'is_active'          => ['nullable', 'boolean'],
//            'lastname'  => ['nullable', 'string',"min:4",'max:60'],
//            'type'      => ['required', 'string',Rule::in(MembersType::values())],
              'sku'       => ['nullable','string',$uniqueSku,'max:255'],
//            'email'     => ['nullable', 'string',$uniqueEmail,'max:255'],
//            'phone'     => ['nullable', 'numeric',$uniquePhone],

           // 'publishedAt' => ['nullable', JsonApiRule::dateTime()],

            //'topic_format_code' => JsonApiRule::toOne(),
        ];
    }

}
