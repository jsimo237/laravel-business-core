<?php

namespace Kirago\BusinessCore\Modules\CoreManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;


/**
 * @property string code
 * @property string name
 * @property string color
 * @property string icon
 * @property array<string,string> style
 */
class Status extends BaseModel {
    use HasCustomPrimaryKey;

    protected $table = "core_mgt__statuses";
    protected $guarded = [];

    public array $translatable = ['name'];  // Champs translatables

    protected $casts = [
      'style' => "array"
    ];


    //GETTERS

    public function getBadgeDotAttribute(): string
    {
        return "<i class='badge-dot' style='background-color: $this->color !important;'></i> $this->name";
    }

    public function getBadgeLabelAttribute(): string
    {
        $status = $this;
        $style = (is_array($status->style))
                ?  json_encode($status->style['label']) ?? ""
                : $status->style ?? "";

        $style = str_replace("{","",$style);
        $style = str_replace("}","",$style);
        $style = str_replace('"',"",$style);
        $style = str_replace(',',"",$style);

        return "<label class='badge' style='$style'><strong>$status->name</strong></label>";
    }

    public function getObjectName(): string
    {
       return $this->getKeyName();
    }
}
