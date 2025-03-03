<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits\HasOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Scopes\PermissionGlobalScope;
use Kirago\BusinessCore\Support\Bootables\Activable;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission {

    use HasFactory,SoftDeletes,
        AuthorableTrait,
        Activable,
        HasOrganization;

    protected $guarded = ["created_at"];

    protected array $hidden = ['pivot'];

    protected string $table = "security_mgt__permissions";


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
