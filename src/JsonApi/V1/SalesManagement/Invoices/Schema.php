<?php

namespace Kirago\BusinessCore\JsonApi\V1\SalesManagement\Invoices;

use Kirago\BusinessCore\Support\Helpers\JsonApiHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\ArrayHash;
use LaravelJsonApi\Eloquent\Fields\ArrayList;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasManyThrough;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Relations\MorphTo;
use LaravelJsonApi\Eloquent\Fields\Attribute;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema as JsonApiSchema;

class Schema extends JsonApiSchema {

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = BcInvoice::class;

    /**
     * The maximum include path depth.
     *
     * @var int
     */
    protected int $maxDepth = 10;


    public static function type(): string {
        return 'invoices';
    }


    public function fields(): iterable {
        return [
            ID::make(),
            Str::make("reference","code")->sortable()->readOnly(),
            Str::make("status")->sortable(),
            Str::make("note"),

            ArrayList::make("discounts"),

            Number::make("amount")->sortable(),
            Str::make('note'),
            Str::make('status'),

            DateTime::make('processed_at')->sortable()->readOnly(),
            DateTime::make('expired_at')->sortable()->readOnly(),

            MorphTo::make("recipient")->types('customers',"staffs")->readOnly(),

            HasMany::make('items')->type('invoice-items')->readOnly(),
            HasMany::make('payments')->type('payments')->readOnly(),
            BelongsTo::make('order')->type('orders')->readOnly(),
            HasManyThrough::make('orderItems')->type('order-items'),

          //  HasMany::make('recipient')->type('invoices')->readOnly(),

            ArrayHash::make('pricing')->extractUsing(function (BcInvoice $model) {

                return [
                    "taxes" => $model->getTaxes(),
                    "subtotal" => $model->getSubTotalAmount(),
                    //"discount" => $model->getDiscounts(),
                    "total" => $model->getTotalAmount(),
                    "total_paid" => $model->getTotalPaid(),
                    "total_remaning" => $model->getTotalRemaining(),
                ];
            }),

            ...JsonApiHelper::billingInformationsFields(),

            ...JsonApiHelper::commonsFields()
        ];
    }


    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array{
        return [
            WhereIdIn::make($this),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator{
        return PagePagination::make();
    }

    /**
     * Build an index query for this resource.
     *
     * @param Request|null $request
     * @param Builder $query
     * @return Builder
     */
    public function indexQuery(?Request $request, Builder $query): Builder{
        if ($user = optional($request)->user()) {
//            return $query->where(function (Builder $q) use ($user) {
//                return $q->whereNotNull('published_at')->orWhere('author_id', $user->getKey());
//            });
        }

        return $query;
    }
}
