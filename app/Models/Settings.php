<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'rix_settings';
    protected $primaryKey = 'setting_id';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($setting) {
            self::cacheForgets($setting->setting_type);
        });
        self::updated(function ($setting) {
            self::cacheForgets($setting->setting_type);
        });
        self::deleted(function ($setting) {
            self::cacheForgets($setting->setting_type);
        });
    }

    private static function cacheForgets($type)
    {
        if ($type === 'security')
            Helper::forget('SETTINGS','SECURITY');
        else if ($type === 'email')
            Helper::forget('SETTINGS','EMAIL');
    }
}
