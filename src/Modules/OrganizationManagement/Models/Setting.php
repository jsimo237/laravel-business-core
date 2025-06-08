<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\LocalizationManagement\Constants\SettingsKeys;


/**
 * @property string|int id
 * @property string key
 * @property string value
 * @property string type
 * @property string description
 */
class Setting extends BaseModel {

    protected $table = "organization_mgt__settings";


    const TYPE_TEXT = "text";
    const TYPE_LONG_TEXT = "long-text";
    const TYPE_OBJECT = "object";
    const TYPE_ARRAY = "array";
    const TYPE_BOOLEAN = "boolean";
    const TYPE_NUMBER = "number";

    protected $appends = [
        'display_name',
    ];

    protected $casts = [
     //   'value' => "array",
    ];


    protected static function booted()
    {
        static::saving(function (self $setting) {
            $attributes = $setting->getAttributes();
            $setting->formatValueAsTring();

        });

        static::created(function (self $setting) {

        });

    }

    /** Un seul fichier rataché à l'enregistrement
     * @return mixed
     */
    public function getValueAttribute($value): mixed
    {
        return $this->formatValueAsCorrectType($value);
    }

    private function formatValueAsTring($value = null) : void{
        $value ??= $this->attributes['value'];
        if((is_array($value) or is_object($value))){
            $value = json_encode($value);
        }
        $this->setAttribute("value",(string) $value);
    }
    private function formatValueAsCorrectType($value = null){
        $type = $this->attributes['type'];
        $value ??= $this->attributes['value'];
        return match ($type) {
                self::TYPE_OBJECT => json_decode($value,true),
                self::TYPE_BOOLEAN => boolval($value),
                default => $value
            };
    }


    public function getDisplayNameAttribute(): string
    {
        return ucfirst(str_replace("_"," ",$this->key));
    }

    public function getObjectName(): string
    {
        return $this->key;
    }

    protected function processToUploadFiles(): bool
    {
        if($this->key === SettingsKeys::LOGOS->value && $this->type === self::TYPE_OBJECT){
           return  false;
        }
        return true;
    }

}
