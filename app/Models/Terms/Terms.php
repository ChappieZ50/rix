<?php

namespace App\Models\Terms;

use App\Classes\Sitemap;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Tags\Url;

class Terms extends Model
{
    protected $table = 'rix_terms';
    protected $guarded = [];
    protected $primaryKey = 'term_id';
    protected static $sitemap_tags = 'sitemap_tags.xml';
    protected static $sitemap_categories = 'sitemap_categories.xml';
    protected static $taxonomy;
    public function termTaxonomy()
    {
        return $this->hasOne(TermTaxonomy::class, 'term_id');
    }

    protected static function boot()
    {
        parent::boot();
        TermTaxonomy::created(function ($taxonomy) {
            $term = self::where('term_id', $taxonomy->term_id)->select('slug', 'created_at')->first();
            if (!empty($term)) {
                if ($taxonomy->taxonomy == 'post_tag')
                    Sitemap::insert($term->slug, $term->created_at, self::$sitemap_tags, Url::CHANGE_FREQUENCY_WEEKLY, config('definitions.TAGS_PREFIX'));
                else if ($taxonomy->taxonomy == 'category')
                    Sitemap::insert($term->slug, $term->created_at, self::$sitemap_categories, Url::CHANGE_FREQUENCY_WEEKLY, config('definitions.CATEGORIES_PREFIX'));
            }
        });
        self::updated(function ($term) {
            $taxonomy = TermTaxonomy::where('term_id', $term->term_id)->select('taxonomy')->first();
            if (!empty($taxonomy)) {
                if ($taxonomy->taxonomy == 'post_tag')
                    Sitemap::refreshTags();
                else if ($taxonomy->taxonomy == 'category')
                    Sitemap::refreshCategories();
            }
        });
        self::deleting(function ($term) {
            $taxonomy = TermTaxonomy::where('term_id', $term->term_id)->select('taxonomy')->first();
            if (!empty($taxonomy))
                self::$taxonomy = $taxonomy->taxonomy;
        });
        self::deleted(function () {
            if (self::$taxonomy == 'post_tag')
                Sitemap::refreshTags();
            else if (self::$taxonomy == 'category')
                Sitemap::refreshCategories();
        });
    }
}
