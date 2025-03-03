<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\SalesManagement\Helpers\TaxHelper;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BaseInvoiceItem;
use Kirago\BusinessCore\Support\Bootables\Auditable;

trait WithItemCapacities
{
    use SoftDeletes,HasTaxGroup,Auditable;




}