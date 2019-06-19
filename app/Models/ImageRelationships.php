<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageRelationships extends Model
{
    protected $table = 'rix_image_relationships';
    protected $guarded = [];
    protected $primaryKey = 'relation_id';
    public $timestamps = false;

    public function imageable()
    {

        return $this->morphTo(null, 'meta_type', 'meta_id');
    }

    public function image()
    {
        return $this->belongsTo(Gallery::class,'image_id');
    }
}
