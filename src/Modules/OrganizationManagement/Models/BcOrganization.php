<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kirago\BusinessCore\Database\Factories\OrganizationManagement\OrganizationFactory;
use Kirago\BusinessCore\Constants\Settings;
use Illuminate\Notifications\Notifiable;
use Kirago\BusinessCore\Modules\HasSlug;
use Kirago\BusinessCore\Modules\MediableBcModel;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;



/**
 * @property string|int id
 * @property array $other_phones
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $phone_extension
 * @property string $phone_type
 * @property string $logo
 * @property BcUser $owner
 */
class BcOrganization extends MediableBcModel {

    use Notifiable,HasSlug;


    protected $table = "organization_mgt__organizations";

    //RELATIONS

    /** Une entreprise est lié a responsable
     * @return BelongsTo
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(BcUser::class,"manager_id");
    }

    public function settings(){
        return $this->hasMany(BcSetting::class,"organization_id");
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
        return OrganizationFactory::new();
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
