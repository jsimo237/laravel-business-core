<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Kirago\BusinessCore\Database\Factories\SecurityManagement\UserFactory;
use Kirago\BusinessCore\Modules\CoresManagement\Models\BcMedia;
use Kirago\BusinessCore\Modules\CoresManagement\Traits\Mediable;
use Kirago\BusinessCore\Modules\OrganizationManagement\Contrats\OrganizationScopable;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits\HasOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Traits\UserInteractWithSomeEntity;
use Kirago\BusinessCore\Modules\SecurityManagement\Observers\UserObserver;
use Kirago\BusinessCore\Modules\SecurityManagement\Traits\HasAuthTokens;
use Kirago\BusinessCore\Support\Bootables\Activable;
use Kirago\BusinessCore\Support\Bootables\InteractWithCommonsScopeFilter;
use Spatie\MediaLibrary\HasMedia as SpatieHasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasPermissions as SpatieHasPermissions;
use Spatie\Permission\Traits\HasRoles as SpatieHasRoles;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Laravel\Fortify\TwoFactorAuthenticatable;
//use Laravel\Jetstream\HasProfilePhoto;


/**
 * {@inheritDoc}
 * @property string $firstname
 * @property string|null $lastname
 * @property string|null $fullname
 * @property string|null $initials
 * @property string|null $email
 * @property string|null $username
 * @property string|null $phone
 * @property string|null $country
 * @property string|null $state
 * @property string|null $city
 * @property string|null $zipcode
 * @property string|null $address
 * @property Collection<BcRole> $roles
 * @property Collection<BcPermission> $permissions
 * @property Collection<BcMedia> $media
 */
class BcUser extends Authenticatable implements SpatieHasMedia,OrganizationScopable {
    use  Notifiable,SoftDeletes,HasFactory,
        HasOrganization,Activable,HasAuthTokens,
        SpatieHasRoles,SpatieHasPermissions,
        InteractsWithMedia,
        Mediable,
        InteractWithCommonsScopeFilter;

    use HasRelationships;
    use UserInteractWithSomeEntity;
//    use TwoFactorAuthenticatable;
//    use HasProfilePhoto;


    protected $table = "security_mgt__users";
   // protected string $primaryKey = "id";

    const MORPH_ID_COLUMN = "entity_id";
    const MORPH_TYPE_COLUMN = "entity_type";
    const MORPH_FUNCTION_NAME = "entity";

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        //'two_factor_recovery_codes',
        //'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
       // 'profile_photo_url',
       // "permissions"
    ];


    //    public function getRouteKey(){
//        return "id";
//    }
     public function getRouteKeyName(): string
     {
         return "id";
     }

     public function guardName() : string{
         return $this->entity->getGuardName();
         // return "web";
     }

    protected static function newFactory(){
        return UserFactory::new();
    }

    protected static function booted(){
        //static::addGlobalScope(new UserGlobalScope);

        self::observe([UserObserver::class]);
    }


    //RELATIONS
    /**
     * Relation polymorphique vers un autre model.
     */
    public function entity(): MorphTo
    {
        return $this->morphTo(
                    self::MORPH_FUNCTION_NAME,
                    self::MORPH_TYPE_COLUMN,
                    self::MORPH_ID_COLUMN
                );
    }


    /**
     * @return HasOne
     */
    public function manager(): HasOne{
        return $this->hasOne(BcUser::class,"manager_id");
    }


    /**
     * Mutator for hashing the password on save
     *
     * @param string|null $value
     * @return void
     */
    public function setPasswordAttribute(?string $value)
    {
       if ($value){
           $this->attributes['password'] = Hash::make($value);
       }
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
      //  $this->notify(new ResetPasswordNotification($token));
    }

    //FUNCTIONS
    public function registerMediaCollections(): void {
        $defaultAvatar = get_gravatar($this->email);
                    $this->addMediaCollection('avatar-users')
                         ->singleFile() // ne doit contenir qu'un seul fichier sur la collection ( utilisateur n'a qu'un seul avatar )
                         ->useFallbackUrl($defaultAvatar) // retouné lorsque getUrl = null
                         ->useFallbackPath($defaultAvatar) // retouné lorsque getPath = null

        ;
    }

    public function scopeSuperAdmins($query){
        return $query->whereHas("roles", function ($q){
            return $q->whereName(BcRole::SUPER_ADMIN) ;
        });
    }


    public function getPrivilegesAttribute(){
        return $this->getAllPermissions()->pluck("name")->toArray();
    }


    //ACTIONS
    public function isSuperAdmin(){
        return $this->hasRole(BcRole::SUPER_ADMIN);
    }

    public function isManager(){
        return $this->is_manager;
    }

    /**
     * getActivitylogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    /**
     * @param $wallets
     * @return array
     */
    public function syncRoles( $wallets){

//        if ($wallets instanceof Wallet) $wallets = $wallets->getKey();
//        if ($wallets instanceof Collection) $wallets = $wallets->pluck("id")->toArray();
//        if (is_int($wallets)) $wallets = [$wallets] ;
//        if (is_string($wallets)) $wallets = explode(",",$wallets);
//
//        return $this->wallets()->sync($wallets);
    }


}
