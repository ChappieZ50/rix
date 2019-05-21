<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    use SoftDeletes;
    protected $table = 'rix_posts';
    protected $guarded = [];
    protected $primaryKey = 'post_id';

    public function termRelationship(){
        return $this->hasMany('App\Models\Terms\TermRelationships','post_id');
    }
}
