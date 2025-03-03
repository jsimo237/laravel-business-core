<?php


namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models\Traits;


use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Kirago\BusinessCore\Models\Modules\Localization\Address;
use function Kirago\BusinessCore\Models\LocalizationManagement\Traits\config;

trait Addressable{

    /**
     * Boot the addressable trait for the model.
     *
     * @return void
     */
    public static function bootAddressable(){
        static::deleted(function (self $model) {
            $model->addresses()->delete();
        });
    }

    /**
     * Get all attached addresses to the model.
     *
     * @return MorphMany
     */
    public function addresses(){
        return $this->morphMany(
            config('localization.models.address'),
            Address::MORPH_FUNCTION_NAME,
            Address::MORPH_TYPE_COLUMN,
            Address::MORPH_ID_COLUMN
        );
    }

    /**
     * Find addressables by distance.
     *
     * @param string $distance
     * @param string $unit
     * @param string $latitude
     * @param string $longitude
     *
     * @return Collection
     */
    public function findByDistance($distance, $unit, $latitude, $longitude){
        return $this->addresses()->within($distance, $unit, $latitude, $longitude)->get();

//        $results = [];
//        foreach ($records as $record) {
//            $results[] = $record->addressable;
//        }
//
//        return collect($results);
    }


    public function addAddress(array $datas){
        return $this->addresses()->create($datas);
    }

}
