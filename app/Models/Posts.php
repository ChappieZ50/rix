<?php

namespace App\Models;

use App\Classes\Sitemap;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class Posts extends Model
{
    protected $table = 'rix_posts';
    protected $guarded = [];
    protected $primaryKey = 'post_id';
    protected static $sitemap = 'sitemap_posts.xml';

    public function termRelationships()
    {
        return $this->hasMany('App\Models\Terms\TermRelationships', 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id');
    }

    public function activity()
    {
        return $this->morphOne(Activity::class, 'activityable', 'meta_type', 'meta_id');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'author_id');
    }

    protected static function boot()
    {
        parent::boot();
        self::created(function ($post) {
            Sitemap::insert($post->slug, $post->created_at, self::$sitemap);
            Helper::clearCache('POSTS','USERS');
        });
        self::updated(function ($post) {
            Sitemap::refreshPosts();
            Helper::clearCache('POSTS');
            if (Comments::where('post_id', $post->post_id)->count() > 0)
                Helper::clearCache('COMMENTS','COMPOSE');
        });
        self::deleted(function ($post) {
            Sitemap::delete($post->slug, self::$sitemap);
            Helper::clearCache('POSTS','USERS');
            if (Comments::where('post_id', $post->post_id)->count() > 0)
                Helper::clearCache('COMMENTS','COMPOSE');
        });
    }
}
