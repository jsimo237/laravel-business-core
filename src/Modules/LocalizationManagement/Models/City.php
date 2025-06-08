<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Auditable;
use Kirago\BusinessCore\Modules\LocalizationManagement\Database\Factories\CityFactory;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;

/**
 * @property string|int id
 */
class City extends Model implements EventNotifiableContract {
    use HasFactory,SoftDeletes,Auditable;

    protected $table = "localization_mgt__cities";
    protected $guarded = ["created_at"];
    const FK_ID = "city_id";

    public function getRouteKeyName(): string
    {
        return "id";
    }


    protected static function newFactory(){
        return CityFactory::new();
    }


    //RELATIONS

    /**
     * @return BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class,State::FK_ID);
    }

    /** Le pays (à travers la région)
     * @return HasOneThrough
     */
    public function country(): HasOneThrough
    {
        return $this->hasOneThrough( // [A] le model courant (TransModTown)
            Country::class, // [B] le model de retour
            State::class, // [C] le model intermédiaire en relation avec B
            (new State)->getKeyName(), // PK dans C
            (new Country)->getKeyName(), // PK dans B
            "state_id", // FK de C dans A
            'country_id' // FK de B dans C
        );
    }

    /** Les quartiers
     * @return HasMany
     */
    public function quarters(): HasMany
    {
        return $this->hasMany(Quarter::class, "city_id");
    }

    public function getObjectName(): string
    {
        return $this->name;
    }
}
