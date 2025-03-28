<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Kirago\BusinessCore\Database\Factories\OrganizationManagement\OrganizationFactory;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Activable;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Auditable;
use Kirago\BusinessCore\Modules\CoresManagement\Traits\Mediable;
use Kirago\BusinessCore\Modules\HasSlug;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;
use Kirago\BusinessCore\Support\Constants\BcSettingsKeys;
use Spatie\MediaLibrary\HasMedia as SpatieHasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\SlugOptions;


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
class BcOrganization extends Model implements SpatieHasMedia {

    use HasFactory,SoftDeletes;
        // AuthorableTrait,
    use  Activable,Auditable,HasSlug;

    use Notifiable;

    use InteractsWithMedia,Mediable;

    protected $table = "organization_mgt__organizations";

    protected $casts = [
     //   'taxes' => "array",
     //   'payments_methods' => "array",
    ];

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
     * @param BcSettingsKeys|string $key
     * @param null $default
     * @return mixed
     */
    function getSettingOf(BcSettingsKeys|string $key, mixed $default = null): mixed
    {
        return $this->settings()->firstWhere('key',$key?->value)?->value ?? $default;
    }

    public function getObjectName(): string
    {
        return $this->name;
    }

    public function registerMediaCollections(): void{
        $this->addMediaCollection(Str::plural($this->getMorphClass()))
            ->singleFile() // ne doit contenir qu'un seul fichier sur la collection ( utilisateur n'a qu'un seul avatar )
            ->useFallbackUrl(get_gravatar($this->email ?? fake()->email)) // retouné lorsque getUrl = null
            //->useFallbackUrl(url("img/avatar.png")) // retouné lorsque getUrl = null
        ;

    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                ->generateSlugsFrom('name')
                ->saveSlugsTo('slug');
    }
}
