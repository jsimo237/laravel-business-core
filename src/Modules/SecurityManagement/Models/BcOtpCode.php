<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kirago\BusinessCore\Modules\BaseBcModel;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcCustomer;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

/**
 * @property string code
 * @property BcUser|BcCustomer|BcStaff|Model identifier
 * @property DateTime expired_at
 */
class BcOtpCode extends BaseBcModel
{
    use HasFactory;

    protected $table = "security_mgt__otpcodes";
    protected $guarded = ["id"];

    protected $casts = [
        'expired_at' => "datetime"
    ];


    /**
     * Relation polymorphique vers un autre model.
     */
    public function identifier(): MorphTo
    {
        return $this->morphTo("identifier");
    }

    public function getObjectName(): string
    {
        return $this->code;
    }
}
