<?php

namespace Kirago\BusinessCore\JsonApi\V1\SalesManagement\InvoiceItems;

use Kirago\BusinessCore\Support\Helpers\JsonApiHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Modules\SalesManagement\Models\InvoiceItem;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\ArrayHash;
use LaravelJsonApi\Eloquent\Fields\ArrayList;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOneThrough;
use LaravelJsonApi\Eloquent\Fields\Relations\MorphTo;
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
    public static string $model = InvoiceItem::class;

    /**
     * The maximum include path depth.
     *
     * @var int
     */
    protected int $maxDepth = 10;


    public static function type(): string {
        return 'invoice-items';
    }


    public function fields(): iterable {
        return [
            ID::make('code')->sortable(),
           // Str::make("code")->sortable(),
            Str::make("note"),
            Number::make("unit_price"),
            Number::make("quantity"),
            Number::make("discount"),
            ArrayList::make("taxes"),


            MorphTo::make('invoiceable')->types('subcriptions','subcriptions')->readOnly(),

            ArrayHash::make('pricing')
                ->extractUsing(function (InvoiceItem $model) {
                return [
                    "taxes" => $model->getItemTaxes(),
                    "subtotal" => $model->getItemSubTotalAmount(),
                    "discount" => $model->getItemDiscountAmount(),
                    "total" => $model->getItemTotalAmount(),
                ];
            }),

            BelongsTo::make('invoice')->type('invoices')->readOnly(),
            HasOneThrough::make('order')->type('orders'),

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

        return $query;
    }
}
