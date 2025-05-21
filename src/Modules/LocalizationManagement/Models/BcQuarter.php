<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;
use Staudenmeir\EloquentHasManyDeep\HasOneDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class BcQuarter extends Model implements EventNotifiableContract {
    use HasFactory,SoftDeletes,
        HasRelationships;

    protected $table = "localization_mgt__quarters";
    protected $guarded = ["created_at"];
    const FK_ID = "quarter_id";

    public function getRouteKeyName(){
        return "id";
    }


    protected static function newFactory(){
        //return QuarterFactory::new();
    }


    //RELATIONS

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(BcCity::class,BcCity::FK_ID);
    }

    /**
     * @return HasOneThrough
     */
    public function region(): HasOneThrough
    {
        return $this->hasOneThrough(
                    BcState::class,
                    BcCity::class,
                    "state_id",
                    (new BcState)->getKeyName(),
                    (new BcCity)->getKeyName(),
                    (new BcState)->getKeyName()
                );
    }

    /** Le pays (à travers la ville et la région)
     * @return HasOneDeep
     */
    public function country(): HasOneDeep
    {
        return $this->hasOneDeep( // Model courant (TransModQuarter) [A]
            BcCountry::class, // [B] Model de retour
            [
                BcCity::class, // [C] 1er Model intermédiaire
                BcState::class, // [D] 2e Model intermédiaire
            ],
            [
                "city_id", // [FK1] de C dans A
                "state_id", // [FK2] de D dans C
                "country_id", // [FK3] de B dans D
            ],
            [
                $this->getKeyName(), // [PK1] de A
                (new BcState)->getKeyName(), // [PK2] de D
                (new BcCountry)->getKeyName(), // [PK3] de B
            ]
        );

        /**
         * D.PK3 = B.FK3
         * C.PK2 = D.FK2
         * A.PK1 = C.FK1
         * A.FK1 = ?
         */
    }

    /** L'état (à travers la ville)
     * @return HasOneThrough
     */
    public function state(): HasOneThrough
    {
        return $this->hasOneThrough( // [A] le model courant (TransModQuarter)
            BcState::class, // [B] le model de retour
            BcCity::class, // [C] le model intermédiaire en relation avec B
            (new BcCity)->getKeyName(), // PK dans C
            (new BcState)->getKeyName(), // PK dans B
            "city_id", // FK de C dans A
            'state_id' // FK de B dans C
        );
    }

    public function getObjectName(): string
    {
        return $this->name;
    }
}
