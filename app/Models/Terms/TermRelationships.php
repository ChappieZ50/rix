<?php

namespace App\Models\Terms;

use Illuminate\Database\Eloquent\Model;

class TermRelationships extends Model
{
    protected $table = 'rix_term_relationships';
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'term_relationships_id';
    public function posts(){
        return $this->belongsToMany('App\Models\Posts','rix_posts');
    }
    public function termTaxonomy(){
        return $this->belongsToMany('App\Models\Terms\TermTaxonomy','rix_term_relationships');
    }
}
