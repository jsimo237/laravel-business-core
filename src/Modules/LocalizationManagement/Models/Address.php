<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kirago\BusinessCore\Modules\BaseModel;

//use Jackpopp\GeoDistance\GeoDistanceTrait;

/**
 * @property string|int id
 * @property float latitude
 * @property float longitude
 * @property bool default
 * @property bool is_primary
 */
class Address extends BaseModel {


    protected string $table = "localization_mgt__addresses";
    protected $guarded = ['id','created_at'];

    const MORPH_ID_COLUMN = "addressable_id";
    const MORPH_TYPE_COLUMN = "addressable_type";
    const MORPH_FUNCTION_NAME = "addressable";

    const FK_ID = "address_id";

    protected $casts = [
        'latitude'         => 'float',
        'longitude'        => 'float',
        'default'          => 'boolean',
        'is_primary'       => 'boolean',
    ];

//    protected static function newFactory(){
//        return CompanyFactory::new();
//    }

    /**Create a new Eloquent model instance.
     * @param array $attributes
     */
    public function __construct(array $attributes = []){
       // $this->setTable(config('localization.tables.addresses'));
        $this->latColumn = 'latitude';
        $this->lngColumn = 'longitude';

        parent::__construct($attributes);
    }

    protected static function boot(){
        parent::boot();

        static::saving(function (self $address) {
            $geocoding = config('addressable.geocoding.enabled');
            $geocoding_api_key = config('addressable.geocoding.api_key');

            if ($geocoding and $geocoding_api_key) {

                $segments[] = $address->street;
                $segments[] = sprintf('%s, %s %s', $address->city, $address->state, $address->postal_code);
                $segments[] = country($address->country_code)->getName();

                $query = str_replace(' ', '+', implode(', ', $segments));
                $geocode = json_decode(
                                file_get_contents(
                                    "https://maps.google.com/maps/api/geocode/json?address={$query}&sensor=false&key={$geocoding_api_key}"
                                ));

                if (filled($geocode->results)) {
                    $address->latitude = $geocode->results[0]->geometry->location->lat;
                    $address->longitude = $geocode->results[0]->geometry->location->lng;
                }
            }
        });
    }


    /**Get the owner model of the address.
     * @return MorphTo
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo(
                self::MORPH_FUNCTION_NAME,
                self::MORPH_TYPE_COLUMN,
                self::MORPH_ID_COLUMN,
                'id'
            );
    }

    /** Retourne le model qui a crée l'addresse
     * @return MorphTo
     */
    public function author(): MorphTo
    {
        return $this->morphTo(
                    'author',
                    'author_type',
                    'author_id',
                    'id'
                );
    }

    /**
     * Scope addresses by the given country.
     * @param Builder $builder
     * @param string|array $countriesCode
     * @return Builder
     */
    public function scopeInCountries(Builder $builder,string|array $countriesCode ): Builder
    {
        $countriesCode = is_string($countriesCode) ? json_decode($countriesCode,true) : $countriesCode;
        return $builder->whereIn('country_code', $countriesCode);
    }

    /**
     * Scope addresses by the given language.
     *
     * @param Builder $builder
     * @param string $languageCode
     * @return Builder
     */
    public function scopeInLanguage(Builder $builder, $languageCode): Builder
    {
        return $builder->where('language_code', $languageCode);
    }

    /**
     * Get full name attribute.
     * @return string
     */
    public function getLabelAttribute(): string
    {
        return implode(' ', [$this->given_name, $this->family_name]);
    }


    public function getObjectName(): string
    {
       return $this->label;
    }
}
