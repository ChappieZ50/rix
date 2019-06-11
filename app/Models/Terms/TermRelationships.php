<?php

namespace App\Models\Terms;

use Illuminate\Database\Eloquent\Model;
class TermRelationships extends Model
{
    protected $table = 'rix_term_relationships';
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'term_relationships_id';

    public function posts()
    {
        return $this->belongsTo('App\Models\Posts', 'post_id');
    }

    public function termTaxonomy()
    {
        return $this->belongsTo(TermTaxonomy::class, 'term_taxonomy_id');
    }
}
