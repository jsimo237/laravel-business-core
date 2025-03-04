<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseInvoiceContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseInvoiceItemContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderItemContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\OrderableContrat;


/**
 * @property string|int id
 * @property string name
 * @property string sku
 * @property string description
 * @property float price
 */
class Product extends BaseModel implements OrderableContrat
{

    protected $table = "sales_mgt__products";


    //
    public function getObjectName(): string
    {
        return $this->name;
    }

    public function getItemId(): string|int
    {
       return $this->getKey();
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExcerpt(): ?string
    {
       return $this->description;
    }

    public function getProductId(): string
    {
        return $this->getKey();
    }

    public function getOrder(): ?BaseOrderContract
    {
        return $this->order;
    }

    public function getInvoice(): ?BaseInvoiceContract
    {
        return $this->invoice;
    }

    public function getInvoiceItem(): ?BaseInvoiceItemContrat
    {
        return $this->invoiceItem;
    }

    public function getOrderItem(): ?BaseOrderItemContrat
    {
        return $this->orderItem;
    }

    public function invoice(): HasOneThrough
    {
        return $this->hasOneThrough(
                        Invoice::class,
                        InvoiceItem::class,
                        InvoiceItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
                        'id',               // Clé primaire sur Invoice
                        'id',               // Clé primaire sur Product
                        'invoice_id'         // Clé étrangère sur InvoiceItem (vers Invoice)
                    )
                    ->where((new InvoiceItem)->getTable().".".InvoiceItem::MORPH_TYPE_COLUMN,(new static)->getMorphClass())
                ;
    }

    public function invoiceItem(): MorphOne
    {
        return $this->morphOne(
                        InvoiceItem::class,
                        InvoiceItem::MORPH_FUNCTION_NAME,
                        InvoiceItem::MORPH_TYPE_COLUMN,
                    );
    }

    public function order(): HasOneThrough
    {
        return $this->hasOneThrough(
                        Order::class,
                        OrderItem::class,
                        OrderItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
                        'id',               // Clé primaire sur Order
                        'id',               // Clé primaire sur Product
                        'order_id'         // Clé étrangère sur OrderItem (vers Order)
                    )
                    ->where((new OrderItem)->getTable().".".OrderItem::MORPH_TYPE_COLUMN,(new static)->getMorphClass())
                    ;
    }

    public function orderItem(): MorphOne
    {
        return $this->morphOne(
                    OrderItem::class,
                    OrderItem::MORPH_FUNCTION_NAME,
                    OrderItem::MORPH_TYPE_COLUMN,
                );
    }
}