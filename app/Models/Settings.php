<?php

namespace App\Models;

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
            if ($setting->setting_type === 'security')
                \Cache::forget('SETTINGS.SECURITY');
        });
        self::updated(function ($setting) {
            if ($setting->setting_type === 'security')
                \Cache::forget('SETTINGS.SECURITY');
        });
        self::deleted(function ($setting) {
            if ($setting->setting_type === 'security')
                \Cache::forget('SETTINGS.SECURITY');
        });
    }
}
