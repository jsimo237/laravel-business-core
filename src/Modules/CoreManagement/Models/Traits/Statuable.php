<?php


namespace Kirago\BusinessCore\Modules\CoreManagement\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kirago\BusinessCore\Modules\CoreManagement\Models\Status;

trait Statuable{


    /**
     * @return string
     */
    public function getStatusClass(){
        return Status::class;
    }

    /**
     * @return string
     */
    public static function getStatusColumn(){
        return "status_code";
    }

    /**
     * @return BelongsTo
     */
    public function status(){
        return $this->belongsTo((new self)->getStatusClass(), self::getStatusColumn());
    }

    /**
     * @param string $statusCode
     * @return bool
     */
    public function setStatusTo(string $statusCode): mixed{
        return $this->update([self::getStatusColumn() => $statusCode]);
    }
}
