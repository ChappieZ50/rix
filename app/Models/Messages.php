<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'message_id';
    protected $table = 'rix_messages';
}
