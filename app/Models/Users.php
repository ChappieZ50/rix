<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'rix_users';
    protected $guarded = [];
    protected $primaryKey = 'user_id';

    public function post()
    {
        return $this->hasMany(Posts::class);
    }
}
