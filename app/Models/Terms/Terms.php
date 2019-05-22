<?php

namespace App\Models\Terms;

use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    protected $table = 'rix_terms';
    protected $guarded = [];
    protected $primaryKey = 'term_id';

    public function termTaxonomy()
    {
        return $this->hasOne('App\Models\Terms\TermTaxonomy','term_id');
    }
}