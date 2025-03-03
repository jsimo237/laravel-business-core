<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Contrats;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;

interface OrganizationScopable
{

    /**
     * getOrganization
     *
     * @return ?Organization
     */
    public function getOrganization(): ?Organization;

    /**
     * Undocumented function
     */
    public function organization(): BelongsTo;

    /**
     * Undocumented function
     */
    public function scopeOrganization(Builder $query, string|int|Organization $organization): Builder;
}