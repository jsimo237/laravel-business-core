<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

/**
 * @property string code
 * @property User|Customer|Staff|Model identifier
 * @property DateTime expired_at
 */
class OtpCode extends BaseModel
{
    use HasFactory;

    protected $table = "security_mgt__otpcodes";
    protected $guarded = ["id"];

    protected $casts = [
        'expired_at' => "datetime"
    ];

    public $authorable = [
       // 'created_by_column_name' => 'custom_created_by',
       // 'updated_by_column_name' => 'custom_updated_by',
        'set_author_when_creating' => false,
        'set_author_when_updating' => false,
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
