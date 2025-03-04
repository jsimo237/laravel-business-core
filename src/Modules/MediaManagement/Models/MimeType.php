<?php

namespace Kirago\BusinessCore\Modules\MediaManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MimeType extends Model{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table =  "medias_mgt__mime_types";

    //Images
    const PNG = "png";
    const JPG = "jpg";
    const JPGE = "jpge";
    const GIF = "gif";
    const SVG = "svg";

    //Videos
    const MP4 = "mp4";
    const MOV = "mov";
    const AVI = "avi";
    const MKV = "mkv";

    //Audios
    const MP3 = "mp3";
    const MOOV = "moov";

    //Documents
    const TXT = "txt";
    const DOC = "doc";
    const DOCX = "docx";
    const XLS = "xls";
    const XLSX = "xlsx";
    const PDF = "pdf";


    /*toutes les extensions 'images'*/
    public static function images(){
        return [
          self::PNG,
          self::JPG,
          self::JPGE,
          self::GIF,
        ];
    }

    public static function audios(){
        return [
            self::MP3,
        ];
    }


    public static function videos(){
        return [
            self::MP4,
            self::MOV,
            self::AVI,
        ];
    }

    public static function documents(){
        return [
            self::TXT,
            self::DOC,
            self::XLS,
            self::XLSX,
            self::PDF,
        ];
    }
}
