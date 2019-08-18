<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'message_id';
    protected $table = 'rix_messages';

    protected static function boot()
    {
	parent::boot();
       self::created(function () {
            \Cache::tags('COMPOSE')->forget('MESSAGES');
            \Cache::tags('MESSAGES')->flush();
        });
        self::updated(function () {
            \Cache::tags('COMPOSE')->forget('MESSAGES');
            \Cache::tags('MESSAGES')->flush();
        });
        self::deleted(function () {
            \Cache::tags('COMPOSE')->forget('MESSAGES');
            \Cache::tags('MESSAGES')->flush();
        });
    }

}
