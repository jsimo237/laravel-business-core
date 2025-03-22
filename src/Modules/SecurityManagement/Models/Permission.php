<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits\HasOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Scopes\PermissionGlobalScope;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission {

    use HasFactory,SoftDeletes,
        HasOrganization;

    protected $guarded = ["created_at"];

    protected $hidden = ['pivot'];

    protected $table = "security_mgt__permissions";


    protected static function booted(){

        static::addGlobalScope(new PermissionGlobalScope);
    }


    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(PermissionGroup::class,"group_code");
    }


}
