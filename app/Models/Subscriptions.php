<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    protected $guarded = [];
    protected $table = 'rix_subscriptions';
    protected $primaryKey = 'subscription_id';

    protected static function boot()
    {
        parent::boot();
        self::created(function () {
            Helper::clearCache('SUBSCRIPTIONS');
        });
        self::deleted(function () {
            Helper::clearCache('SUBSCRIPTIONS');
        });
    }
}
