<?php

namespace Kirago\BusinessCore\Modules;

use Axn\EloquentAuthorable\AuthorableTrait;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Activable;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Auditable;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\InteractWithCommonsScopeFilter;
use Kirago\BusinessCore\Modules\OrganizationManagement\Contrats\OrganizationScopable;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits\HasOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;


/**
 * @property string|int id
 * @property string|DateTime|null created_at
 * @property string|DateTime|null updated_at
 * @property string|DateTime|null deleted_at
 * @property int|null created_by
 * @property int|null updated_by
 * @property int|null deleted_by
 * @property BcUser createdBy
 * @property BcUser updatedBy
 * @property BcUser deletedBy
 */
abstract class BaseBcModel extends Model
    implements EventNotifiableContract,
            OrganizationScopable
{

    use HasFactory,SoftDeletes,
       // AuthorableTrait,

        HasOrganization,
        InteractWithCommonsScopeFilter;

    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool $timestamps
     */
    public $timestamps = true;

}
