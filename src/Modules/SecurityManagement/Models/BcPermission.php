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

             $roleSuper = BcRole::findByName(BcRole::SUPER_ADMIN);

             write_log("permission",$permission);
             write_log("role",$roleSuper);

             $roleSuper?->givePermissionTo($permission);
        });
    }


    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(BcPermissionGroup::class,"group");
    }


}
