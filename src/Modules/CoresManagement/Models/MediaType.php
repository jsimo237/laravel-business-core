<?php

namespace Kirago\BusinessCore\Modules\CoresManagement\Models;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model{

    const TABLE_NAME = "cores_mgt__medias_types";
    protected $guarded = ['id'];
    protected $table =  "medias_mgt__medias_types";

    const IMAGE = "IMAGE";
    const VIDEO = 'VIDEO';
    const DOCUMENT = 'DOCUMENT';
    const AUDIO = "AUDIO";

}
