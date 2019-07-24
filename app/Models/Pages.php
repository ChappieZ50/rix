<?php

namespace App\Models;

use App\Classes\Sitemap;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Tags\Url;

class Pages extends Model
{
    protected $table = 'rix_pages';
    protected $primaryKey = 'page_id';
    protected $guarded = [];
    protected static $sitemap = 'sitemap_pages.xml';

    protected static function boot()
    {
        parent::boot();
        self::created(function ($page) {
            Sitemap::insert($page->slug, $page->created_at, self::$sitemap, Url::CHANGE_FREQUENCY_DAILY);
        });
        self::updated(function () {
            Sitemap::refreshPages();
        });
        self::deleted(function ($page) {
            Sitemap::delete($page->slug, self::$sitemap);
        });
    }
}
