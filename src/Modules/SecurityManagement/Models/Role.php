<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits\HasOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Observers\RoleObserver;
use Kirago\BusinessCore\Support\Bootables\Activable;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole{

    use HasFactory,SoftDeletes,
        AuthorableTrait,
        Activable,
        HasOrganization;

    protected $hidden = ['pivot'];
    // protected $dispatchesEvents = [];

    protected $table = "security_mgt__roles";

    const SUPER_ADMIN = "Super-Admin";
    const MANAGER = "Main-Manager";

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
