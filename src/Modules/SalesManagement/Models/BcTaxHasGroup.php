<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\BaseBcModel;

/**
 * @property string|int $tax_id
 * @property string|int $tax_group_id
 * @property float $seq_number
 */
class BcTaxHasGroup  extends BaseBcModel
{

    protected $table = "sales_mgt__tax_has_groups";

    protected $fillable = [
        'seq_number',
        'tax_id',
        'tax_group_id',
    ];



    public function getObjectName(): string
    {
        return $this->name;
    }


}
