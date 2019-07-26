<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = 'rix_notifications';
    protected $primaryKey = 'notification_id';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        self::created(function () {
            Helper::forget('COMPOSE','NOTIFICATIONS');
        });
    }

}
