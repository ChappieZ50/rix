<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'rix_comments';
    protected $guarded = [];
    protected $primaryKey = 'comment_id';

    public function post()
    {
        return $this->belongsTo('App\Models\Posts','post_id');
    }

    public function activity(){
        return $this->morphOne('App\Models\Activity','activityable','meta_type','meta_id');
    }
}
