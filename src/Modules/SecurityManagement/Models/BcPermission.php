<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Scopes\PermissionGlobalScope;
use Spatie\Permission\Models\Permission as SpatiePermission;


/**
 * @property int id
 * @property string name
 * @property string guard_name
 * @property string description
 * @property string group
 * @property BcRole[] permissions
 */
class BcPermission extends SpatiePermission {

    use HasFactory,SoftDeletes;

    protected $guarded = ["created_at"];

    protected $hidden = ['pivot'];

    const TABLE_NAME = "security_mgt__permissions";

    protected $table = self::TABLE_NAME;


    protected static function booted(){

        static::addGlobalScope(new PermissionGlobalScope);

        static::created(function (self $permission){

            static::syncAllPermissionsToSuperAdminRole();

        });
    }


    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(BcPermissionGroup::class,"group");
    }

    public static function syncAllPermissionsToSuperAdminRole(){
        try {
            $roleSuper = BcRole::firstWhere("name",BcRole::SUPER_ADMIN);

            $roleSuper?->givePermissionTo(self::pluck('id')->toArray());
        }catch (\Exception $exception){
          write_log("permissions/syncAllPermissionsToSuperAdminRole",$exception);
        }
    }


}
