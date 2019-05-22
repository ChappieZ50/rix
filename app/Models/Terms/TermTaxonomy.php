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
        return $this->belongsTo('App\Models\Terms\Terms','term_id');
    }
    public function termRelationships()
    {
        return $this->hasMany('App\Models\Terms\TermRelationships','term_taxonomy_id');
    }
}