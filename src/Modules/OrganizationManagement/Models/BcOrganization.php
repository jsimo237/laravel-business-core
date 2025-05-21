<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Activable;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Auditable;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Mediable;
use Kirago\BusinessCore\Modules\HasSlug;
use Kirago\BusinessCore\Modules\LocalizationManagement\Constants\BcSettingsKeys;
use Kirago\BusinessCore\Modules\OrganizationManagement\Factories\OrganizationFactory;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;
use Kirago\BusinessCore\Support\Constants\BusinessCoreConfigs;
use Spatie\MediaLibrary\HasMedia as SpatieHasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\SlugOptions;


/**
 * @property string|int id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $slug
 * @property string $description
 * @property string $phone_extension
 * @property string $phone_type
 * @property string $logo
 * @property BcUser $owner
 * @property BcSetting $settings
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
        $configs = BusinessCoreConfigs::getModelsInteractWithOrganization();

        // Récupère toutes les classes, que ce soit avec ou sans config
        $allTargets = collect($configs)->mapWithKeys(function ($value, $key) {
            // Cas 1 : modèle avec config (clé = class)
            if (is_string($key) && is_array($value)) {
                return [$key => $value];
            }

            // Cas 2 : modèle simple (valeur = class)
            if (is_string($value)) {
                return [$value => null];
            }

            return []; // sécurité
        });

        if (!$allTargets->has($target)) {
            throw new \InvalidArgumentException("Invalid target type: {$target}.");
        }

        $config = $allTargets->get($target);

        // Relation BelongsToMany
        if (is_array($config) && ($config['type'] ?? null) === BelongsToMany::class) {
            return $this->belongsToMany(
                $target,
                (new $config['related_model'])->getTable(),
                'organization_id',
                $config['related_column_name']
            );
        }

        // Relation HasMany
        return $this->hasMany($target, 'organization_id');
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
        if(!is_string($key)){
            $key = $key?->value;
        }
        return $this->settings()->firstWhere('key',$key)?->value ?? $default;
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
