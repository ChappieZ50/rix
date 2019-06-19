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
    public function image()
    {
        return $this->morphOne(ImageRelationships::class, 'imageable', 'meta_type', 'meta_id');
    }
}
