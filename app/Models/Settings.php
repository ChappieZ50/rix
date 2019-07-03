<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'rix_settings';
    protected $primaryKey = 'setting_id';
    protected $guarded = [];
}
