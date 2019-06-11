<?php

namespace App\Models\Terms;

use Illuminate\Database\Eloquent\Model;

class TermTaxonomy extends Model
{
    protected $table = 'rix_term_taxonomy';
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'term_taxonomy_id';
    public function terms(){
        return $this->belongsTo(Terms::class,'term_id');
    }
    public function termRelationships()
    {
        return $this->hasMany(TermRelationships::class,'term_taxonomy_id');
    }
}
