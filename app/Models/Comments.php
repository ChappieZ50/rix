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
        return $this->belongsTo(Posts::class, 'post_id');
    }

    public function activity()
    {
        return $this->morphOne(Activity::class, 'activityable', 'meta_type', 'meta_id');
    }

    public function parent(){
        return $this->belongsTo($this,'parent_comment');
    }

    public function children()
    {
        return $this->hasMany($this,'parent_comment');
    }

}
