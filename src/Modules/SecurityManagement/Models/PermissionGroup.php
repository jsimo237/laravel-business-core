<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sushi\Sushi;

class PermissionGroup extends Model{
    use HasFactory;

    protected $table = "security_mgt__permission_groups";
    protected $guarded = [];
    public $timestamps = false;
    const FK_ID = "permission_group_id";

    const ROLE = 1;
    const USER = 2;
    const ORGANISER = 3;
    const ATTENDEE = 4;
    const VOTE = 5;
    const SETTING = 6;
    const ACCOUNT = 7;
    const ELECTOR = 8;
    const COUNTRY = 9;

    public $rows = [
      ["id" => self::ROLE, "name" => "Rôle",],
      ["id" => self::USER, "name" => "Utilisateur",],
      ["id" => self::ORGANISER, "name" => "Organisateur",],
      ["id" => self::ELECTOR, "name" => "Electeur",],
      ["id" => self::ATTENDEE, "name" => "Participant",],
      ["id" => self::VOTE, "name" => "Vote",],
      ["id" => self::SETTING, "name" => "Paramètre",],
      ["id" => self::ACCOUNT, "name" => "Compte",],
      ["id" => self::COUNTRY, "name" => "Pays",],
    ];



    //RELATIONS

    /**
     * @return HasMany
     */
    public function permissions(){
        return $this->hasMany(Permission::class,"permission_group_id");
    }
}
