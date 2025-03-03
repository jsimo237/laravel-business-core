<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kirago\BusinessCore\Database\Factories\UserManagement\CompanyFactory;
use Kirago\BusinessCore\Enums\Settings;
use Illuminate\Notifications\Notifiable;
use Kirago\BusinessCore\Modules\MediableModel;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;


/**
 * @property string|int id
 * @property array $other_phones
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $phone_extension
 * @property string $phone_type
 * @property string $logo
 * @property User $owner
 */
class Organization extends MediableModel {

    use Notifiable;

    protected string $table = "organization_mgt__organizations";


    //RELATIONS

    /** Une entreprise est lié a responsable
     * @return HasOne
     */
    public function manager(): HasOne
    {
        return $this->hasOne(User::class,"manager_id");
    }

    public function settings(){
        return $this->hasMany(Setting::class,"organization_id");
    }

    /**
     * @param string $target
     * @return BelongsToMany|HasMany
     */
    public function relatedEntities(string $target): HasMany|BelongsToMany
    {

        $configs = config('business-core.models-interact-with-organization');

        $allTargets = array_keys($configs);

        if (!in_array($target, $allTargets)) {
            throw new \InvalidArgumentException("Invalid target type: {$target}. Yo can add it in config/business-core.php key 'models-interact-with-organization'");
        }

        $config = $allTargets[$target];
        $type = $config['type'] ?? null;

        if ($type === BelongsToMany::class){
            return $this->belongsToMany(
                            $target,
                            (new $config['related_model'])->getTable(),
                            "organization_id",
                            $config['related_column_name'],

                        )
                      //  ->as('subscription')
                      //  ->withPivot('value as count_value')
                ;
        }

        return $this->hasMany($target, "organization_id");
    }



    protected static function newFactory(){
        return CompanyFactory::new();
    }


    //FUNCTIONS

    /**
     * @param Settings|string $key
     * @param null $default
     * @return mixed
     */
    function getSettingOf(Settings|string $key,mixed $default = null): mixed
    {
        return $this->settings()->firstWhere('key',$key?->value)?->value ?? $default;
    }

    public function getObjectName(): string
    {
        return $this->name;
    }
}
