<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kirago\BusinessCore\Modules\BaseBcModel;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseInvoiceContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseInvoiceItemContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderItemContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BillableProduct;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\OrderableContrat;


/**
 * @property string|int id
 * @property string name
 * @property string sku
 * @property string description
 * @property float price
 */
class BcProduct extends BaseBcModel implements BillableProduct
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

    public function getNote(): ?string
    {
       return $this->description;
    }

    public function getProductId(): string
    {
        return $this->getKey();
    }
}