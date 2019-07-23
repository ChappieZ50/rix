<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'rix_gallery';
    protected $guarded = [];
    protected $primaryKey = 'image_id';

    protected static function boot()
    {
        parent::boot();
        self::created(function () {
            Helper::clearCache('IMAGES');
        });
        self::updated(function () {
            Helper::clearCache('IMAGES');
        });
        self::deleted(function () {
            Helper::clearCache('IMAGES');
        });
    }

}
