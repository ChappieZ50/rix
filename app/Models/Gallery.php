<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'rix_gallery';
    protected $guarded = [];

    static function get_gallery($select = ['*'], $paginate,$order = 'desc')
    {
        return self::select($select)->orderBy('id',$order)->paginate($paginate);
    }
}
