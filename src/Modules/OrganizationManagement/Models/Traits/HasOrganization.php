<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kirago\BusinessCore\Modules\OrganizationManagement\Contrats\OrganizationScopable;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;

/**
 * @property string|int $organization_id
 * @property BcOrganization $organization
 */
trait HasOrganization
{

    public static function bootHasOrganization(){

      //  static::addGlobalScope(new HasOrganizationGlobalScope);

        static::saving(function (self $model) {

            // $user = auth(activeGuard())->user();

            if (!$model->organization_id && $currentOrganization = currentOrganization()) {
                $model->setAttribute('organization_id', $currentOrganization->getKey());
            }
        });


    }

    /**
     * Undocumented function
     *
     * @return ?BcOrganization
     */
    public function getOrganization(): ?BcOrganization
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
                        BcOrganization::class,
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
        return $this->belongsTo(BcOrganization::class,"organization_id");
    }

    public function scopeOrganizationId(Builder $query, string|int|BcOrganization $organization): Builder
    {
        return  $query->where(
                    $query->getModel()->getTable() . '.organization_id',
                    $organization?->getKey()
                );
    }

    public function scopeOrganizatioSzn(Builder $query, string|int|BcOrganization $organization): Builder
    {
        if ($organization) {
//            if ($this->hasSystemObjects()) {
//                return $query->where('system', '1')->orWhere($query->getModel()->getTable() . '.organization_id', '=', $organization);
//            }

            return $query->organizationId($organization);
        } else {
            return $query->whereNull($query->getModel()->getTable() . '.organization_id');
        }
    }

}