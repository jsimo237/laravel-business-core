<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kirago\BusinessCore\Modules\OrganizationManagement\Contrats\OrganizationScopable;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Scopes\HasOrganizationGlobalScope;

trait HasOrganization
{

    public static function bootHasOrganization(){

        static::addGlobalScope(new HasOrganizationGlobalScope());

        static::saving(function (OrganizationScopable $model) {

            /** @var ?User */
            // $user = auth(activeGuard())->user();

            if ($currentOrganization = currentOrganization()) {
                if (!$model->getOrganization()) {
                    $model->organization()->associate($currentOrganization->getKey());
                }
                else {
                    if (!$model->getOrganization()->is($currentOrganization->getKey())) {
                        abort(403, 'You are not allowed to edit this model');
                    }
                }
            }
        });


    }

    /**
     * Undocumented function
     *
     * @return ?Organization
     */
    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }


    /**
     * Les organisations aux-quelles le model est liées
     * @return BelongsToMany|HasMany|null
     */
    public function organizations(): HasMany|BelongsToMany|null
    {

        $target = static::class; // Récupération de la classe de l'objet actuel

        $configs = config('business-core.models-interact-with-organization');

        $allTargets = array_keys($configs);

        if (!in_array($target, $allTargets)) {
            throw new \InvalidArgumentException("Invalid target type: {$target}. Yo can add it in config/business-core.php key 'models-interact-with-organization'");
        }

        $config = $allTargets[$target]; // Récupérer la configuration associée au modèle
        $type = $config['type'] ?? null;

        if ($type === BelongsToMany::class){
            return $this->belongsToMany(
                        Organization::class,
                        (new $config['related_model'])->getTable(),
                        $config['related_column_name'],
                        "organization_id",
                    )
                ;
        }

        return null;
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class,"organization_id");
    }

    public function scopeOrganizationId(Builder $query, string|int|Organization $organization): Builder
    {
        $organization = ($organization instanceof Organization) ? $organization->getKey() : $organization;

        return  $query->where($query->getModel()->getTable() . '.organization_id', $organization);
    }

}