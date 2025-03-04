<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\LocalizationManagement\Database\Factories\StateFactory;
use Kirago\BusinessCore\Support\Bootables\Paginable;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;

class State extends Model implements EventNotifiableContract {
    use HasFactory,SoftDeletes,Paginable;

    protected $table = "localization_mgt__states";
    protected $guarded = [];
    const FK_ID = "state_id";

    public function getRouteKeyName(): string
    {
        return "id";
    }

    protected static function newFactory(){
        return StateFactory::new();
    }

    //RELATIONS

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    /**Les villes d'une région
     * @return HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class,"state_id");
    }

    /** Les quartiers d'une région (à travers les villes)
     * @return HasManyThrough
     */
    public function quarters(): HasManyThrough
    {
        return $this->hasManyThrough(
            Quarter::class, // le model/table final (qu'on veut retourner)
            City::class, // le model/table intermédiare
            "state_id", // [FK] du model courant se trouvant dans le model intermédiare
            "city_id", // [FK] du model intermédiaire de trouvant dans le model final
            $this->getKeyName(), // [PK] du model courant
            (new City)->getKeyName() // [PK] du model intermédiare
        );
    }

    public function getObjectName(): string
    {
       return $this->name;
    }
}
