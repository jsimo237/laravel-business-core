<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;

use Couchbase\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits\HasOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Scopes\PermissionGlobalScope;
use Spatie\Permission\Models\Permission as SpatiePermission;

class BcPermission extends SpatiePermission {

    use HasFactory,SoftDeletes,
        HasOrganization;

    protected $guarded = ["created_at"];

    protected $hidden = ['pivot'];

    protected $table = "security_mgt__permissions";


    protected static function booted(){

        static::addGlobalScope(new PermissionGlobalScope);

        static::created(function (self $permission){

            // $roleSuper = Role::gi
        });
    }


    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(BcPermissionGroup::class,"group_code");
    }


}
