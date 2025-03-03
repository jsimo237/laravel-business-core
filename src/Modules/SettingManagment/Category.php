<?php

namespace Kirago\BusinessCore\Modules\SettingManagment;

use AliBayat\LaravelCategorizable\Category as AlibatCategoryModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\UserManagement\Traits\Auditable;
use Kirago\BusinessCore\Support\Models\Bootables\Sluglable;

class Category extends AlibatCategoryModel {
    use HasFactory,SoftDeletes,
        Auditable,Sluglable;

    const TABLE_NAME = "polymorph_mgt__categories";
    protected $guarded = ['id'];
    protected $table = "polymorph_mgt__categories";

    const FK_iD = "category_id";
    const MORPH_ID_COLUMN = "model_id";
    const MORPH_TYPE_COLUMN = "model_type";
    const SLUG_ATTRIBUTS = ["id",'name'];



    //Functions
//    public function getSlugOptions() : SlugOptions{
//        return SlugOptions::create()
//              ->generateSlugsFrom(['name','id'])
//              ->saveSlugsTo('slug')
//           // ->usingSeparator('_')
//        ;
//    }
}
