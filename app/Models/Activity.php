<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'rix_activity';
    protected $guarded = [];
    protected $primaryKey = 'activity_id';
}
