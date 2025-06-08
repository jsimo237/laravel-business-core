<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BillableItem;
use Kirago\BusinessCore\Modules\SalesManagement\Traits\InteractWithInvoiceItemsCapacities;
use Kirago\BusinessCore\Modules\SalesManagement\Traits\InteractWithOrdertemsCapacities;

/**
 * @property string|int id
 * @property string name
 * @property string sku
 * @property string description
 * @property float price
 */
class Product extends BaseModel implements BillableItem
{
    use InteractWithInvoiceItemsCapacities,
        InteractWithOrdertemsCapacities;

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