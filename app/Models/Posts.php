<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = 'rix_posts';
    protected $guarded = [];
    protected $primaryKey = 'post_id';

    public function termRelationships(){
        return $this->hasMany('App\Models\Terms\TermRelationships','post_id');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comments','post_id');
    }

    public function activity(){
        return $this->morphOne(Activity::class,'activityable','meta_type','meta_id');
    }
}
