<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    protected $guarded = [];
    protected $table = 'rix_subscriptions';
    protected $primaryKey = 'subscription_id';
}
