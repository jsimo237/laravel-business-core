<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models;

use Kirago\BusinessCore\Modules\BaseBcModel;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
/**
 * @property string code
 * @property string name
 * @property string description
 */
class BcTimezone extends BaseBcModel {

    protected $table = "localization_mgt__timezones";

    public function getRouteKeyName(){
        return "code";
    }

    public function getObjectName(): string
    {
        return $this->name;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('code')
            ->saveSlugsTo('slug')
            ;
    }
}
