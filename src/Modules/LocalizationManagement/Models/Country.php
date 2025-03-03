<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;

class Country extends BaseModel {
    use HasCustomPrimaryKey;

    protected $table = "localization_mgt__countries";

    protected $guarded = [];

    const FK_ID = "country_code";

   // protected $keyType = "string";

    protected $casts  = [
       // "meta" => 'object',
        "data" => 'array',
    ];

    protected $appends = [
//        "name","indicative",
//       "cca2","cca3"
    ];

    public function getRouteKeyName(): string
    {
        return "country_code";
    }

    public static function locales(){
        return [
            "fr" => 'fra',
            "en" => 'eng',
        ];
    }

    //RELATIONS
    /** Les états/régions d'un pays
     * @return HasMany
     */
    public function states(){
        return $this->hasMany(State::class, self::FK_ID);
    }

    /** Les villes du pays (en passant par les régions)
     * @return HasManyThrough
     */
    public function cities(){
        return $this->hasManyThrough(
            City::class, // le model/table qu'on veut retourner (cities)
            State::class, // le model/table intermédiare (states)
            self::FK_ID, // states.country_id == countries.id
            State::FK_ID, // cities.state_id = states.id
            $this->getKeyName(), // countries.id
            (new State)->getKeyName() // states.id
        );
    }

    /** Les quartiers d'un pays (à travers les régions et les villes)
     * @return HasManyDeep
     */
    public function quarters(){
        return $this->hasManyDeep(
            Quarter::class, // le model/table qu'on veut retourner (quarters)
            [
                State::class, // 1er Model Intermédiare
                City::class // 2e Model intermédiare
            ], // Les models intermédiares ordonnés/liés hiérachiquement par rapport au model courant
            [
                'country_id', //[FK] du model courant se trouvant dans dans le 1er model intermédiare
                'state_id',  //[FK] du 1er model intermédiare se trouvant dans sur le 2e model ("towns.id_region" = "regions.id_region)
                'city_id'     //[FK] du 2e model se trouvant dans le model courant ("quarters.id_town" = "towns.id_town").
            ], // Les clés étrangères
            [
                $this->getKeyName(), //[PK] dans le model dans lequel on se trouve ("countries.id_country")
                (new State)->getKeyName(), // [PK] dans le 2e model intermédiare ("regions.id_region")
                (new City)->getKeyName()  // [PK] dans le 3e model intermédiare ("towns.id_town").
            ]

        );
    }

    //GETTERS

    /** les données recoltées sur l'api
     * @return mixed
     */
    public function getFlagAttribute(){
        return $this->data['cca2'];
    }
    public function getCca2Attribute(){
        return strtolower($this->data['cca2']);
    }
    public function getCca3Attribute(){
        return $this->data['cca3'];
    }


    public function getIndicativeAttribute(){
        $idd = $this->data['idd'];
        if (array_key_exists('root',$idd)){
            return $idd['root'].$idd["suffixes"][0] ?? "";
        }
       return "";
    }
    public function getCurrenciesAttribute(){
        return $this->data['currencies'];
    }
    public function getCurrencyAttribute(){
        return $this->currencies[0]['symbol'];
    }

    public function getNameAttribute(){
        $local = app()->getLocale();
        $locales = self::locales();

        if ( array_key_exists($local,$locales) and array_key_exists("translations",$this->data)){
            $local = $locales[$local];
            $translations = $this->data['translations'];
            return  array_key_exists($local,$this->data['translations'])
                    ? $translations[$local]["common"]
                    : $this->data['name']["common"];
        }
        return $this->data['name']["common"];
    }

    public function getNameIndicativeAttribute(){
        return "($this->indicative) $this->name";
    }

    public function getFlagIconAttribute(){
        $flag = strtolower($this->flag);
        return "<i class='flag-icon flag-icon-$flag' title='$this->name'></i>";
    }

    public function getHtmlNameAttribute(){
        return "$this->flagIcon ($this->indicative) $this->name";
    }
    //*
    public function getObjectName(): string
    {
        return $this->name;
    }
}
