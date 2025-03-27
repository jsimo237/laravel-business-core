<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\BaseBcModel;
use Kirago\BusinessCore\Support\Constants\BcSettingsKeys;


/**
 * @property string|int id
 * @property string key
 * @property string value
 * @property string type
 * @property string description
 */
class BcSetting extends BaseBcModel {

    protected $table = "organization_mgt__settings";


    const TYPE_TEXT = "text";
    const TYPE_LONG_TEXT = "long-text";
    const TYPE_OBJECT = "object";
    const TYPE_ARRAY = "array";
    const TYPE_BOOLEAN = "boolean";
    const TYPE_NUMBER = "number";

    protected static function booted()
    {
        static::saved(function (BcSetting $setting) {
            $setting->processToUploadFiles();
        });

    }

    /** Un seul fichier rataché à l'enregistrement
     * @return Attribute
     */
    public function value(): Attribute
    {
        return Attribute::make(
            set : function ($value){
                if(($this->type === self::TYPE_OBJECT)
                    or is_array($value) or
                    is_object(is_array($value))
                ){
                    return json_encode($value);
                }
                return $value;
            },
            get : function ($value){
                return match ($this->type){
                        self::TYPE_OBJECT => json_decode($value,true),
                        self::TYPE_BOOLEAN => boolval($value),
                        default => $value
                    };
            },
        );
    }

    public function getDisplayNameAttribute(): string
    {
        return ucfirst(str_replace("_"," ",$this->key));
    }

    public function getObjectName(): string
    {
        return $this->key;
    }

    private function processToUploadFiles(): bool
    {
        if($this->key === BcSettingsKeys::LOGOS->value && $this->type === self::TYPE_OBJECT){

        }
        return true;
    }

}
