<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'rix_pages';
    protected $primaryKey = 'page_id';
    protected $guarded = [];
}
