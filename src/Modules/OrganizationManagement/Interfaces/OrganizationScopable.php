<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Interfaces;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;


/**
 * @property BcOrganization organization
 * @property string|int|null organization_id
 */
interface OrganizationScopable
{

    /**
     * getOrganization
     *
     * @return ?BcOrganization
     */
    public function getOrganization(): ?BcOrganization;

    /**
     * Undocumented function
     */
    public function organization(): BelongsTo;

    /**
     * Undocumented function
     */
   // public function scopeOrganization(Builder $query, string|int|BcOrganization $organization): ?Builder;
    public function scopeOrganizationId(Builder $query, string|int|BcOrganization $organization): ?Builder;
}