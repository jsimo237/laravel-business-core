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
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits\HasOrganization;
use Kirago\BusinessCore\Support\Bootables\Activable;
use Kirago\BusinessCore\Support\Bootables\Auditable;
use Kirago\BusinessCore\Support\Bootables\InteractWithCommonsScopeFilter;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;


/**
 * @property string|int id
 * @property string|DateTime|null created_at
 * @property string|DateTime|null updated_at
 * @property string|DateTime|null deleted_at
 */
abstract class BaseModel extends Model implements EventNotifiableContract {

    use HasFactory,SoftDeletes,
        Validable,AuthorableTrait,Auditable,
        Activable,
        HasOrganization,
        InteractWithCommonsScopeFilter;

    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool $timestamps
     */
    public  $timestamps = true;

}
