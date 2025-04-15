<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Activable;
use Kirago\BusinessCore\Modules\OrganizationManagement\Contrats\OrganizationScopable;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits\HasOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Observers\RoleObserver;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * @property int id
 * @property string name
 * @property string guard_name
 * @property string description
 * @property bool editable
 * @property BcPermission[] permissions
 * @property BcOrganization oganization
 */
class BcRole extends SpatieRole implements OrganizationScopable {

    use HasFactory,SoftDeletes,
        AuthorableTrait,
        Activable,
        HasOrganization;

    protected $hidden = ['pivot'];
    // protected $dispatchesEvents = [];
    const TABLE_NAME = "security_mgt__roles";

    protected $table = self::TABLE_NAME;


    const SUPER_ADMIN = "Super-Admin";
    const MANAGER = "Main-Manager";
    const ADMIN_RESSELER = "Admin-Resseller";


    protected $casts = [
        'editable' => 'boolean',
    ];

    protected $appends = [
        "permissions_ids"
    ];

    public function getRouteKeyName(){
        return "id";
    }

    protected static function booted(){
      // static::addGlobalScope(new RoleGlobalScope);

      static::observe([RoleObserver::class]);
    }

    //GETTERS
    public function getPermissionsIdsAttribute(){
        return $this->permissions->pluck('id')->toArray();
    }
}
