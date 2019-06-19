<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'rix_gallery';
    protected $guarded = [];
    protected $primaryKey = 'image_id';

    static function get_gallery($select = [ '*' ], $paginate, $order = 'desc')
    {
        return self::select($select)->orderBy('image_id', $order)->paginate($paginate);
    }

    public function image_relations()
    {
        return $this->hasMany(ImageRelationships::class,'image_id');
    }
}
