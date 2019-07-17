<?php

namespace App\Models;

use App\Classes\Sitemap;
use App\Observers\PagesObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Spatie\Sitemap\Tags\Url;

class Pages extends Model
{
    protected $table = 'rix_pages';
    protected $primaryKey = 'page_id';
    protected $guarded = [];
    protected static $oldSlug;

    protected static function boot()
    {
        parent::boot();
        self::created(function ($page) {
            Sitemap::insert($page->slug,$page->created_at,'sitemap_pages.xml');
        });
        self::updated(function () {
            Sitemap::refreshPages();
        });
        self::deleted(function ($page) {

        });
    }
}
