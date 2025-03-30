<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Auditable;

trait WithItemCapacities
{
    use SoftDeletes,HasTaxGroup,Auditable;




}