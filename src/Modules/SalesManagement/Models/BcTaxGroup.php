<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\BaseBcModel;

/**
 * @property string $name
 * @property string $note
 * @property array $other_phones
 */
class BcTaxGroup  extends BaseBcModel
{


    protected $table = "sales_mgt__taxe_groups";

    protected $fillable = [
        'name',
        'country_code',
        'note',
    ];



    public function getObjectName(): string
    {
        return $this->name;
    }

    public function taxes()
    {
        return $this->belongsToMany(
                        BcTax::class,
                      (new self)->getTable()
                    )
                    ->withPivot('seq_number')
                    ->orderBy('seq_number');
    }
}
