<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\Posts;
use App\Models\Terms\Terms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    protected $sitemap;

    public function __construct()
    {
        $this->sitemap = resource_path('/views/sitemap.blade.php');
    }

    public function index()
    {
        if (!Cache::has('siteMap'))
            $this->create();
        Cache::put('siteMap', true, now()->addMinutes(30));
        return response()->view('sitemap')->header('Content-Type', 'text/xml');
    }

    public function create()
    {
        $sitemap = Sitemap::create();
        $items = $this->items();
        foreach ($items as $key => $value)
            foreach ($value as $item) {
                if ($key === 'terms' && $item->termTaxonomy->taxonomy == 'category')
                    $prefix = config('definitions.CATEGORIES_PREFIX');
                elseif ($key === 'terms' && $item->termTaxonomy->taxonomy == 'post_tag')
                    $prefix = config('definitions.TAGS_PREFIX');
                else
                    $prefix = null;
                $sitemap->add(Url::create($prefix . $item->slug)->setLastModificationDate($item->updated_at));
            }
        $sitemap->add(Url::create('/'));
        \File::put($this->sitemap, $sitemap->render());
        return true;
    }


    private function items()
    {
        $results['terms'] = Terms::with([
            'termTaxonomy' => function ($query) {
                return $query->select('term_id', 'taxonomy');
            } ])->select('slug', 'updated_at', 'term_id')->orderByDesc('term_id')->get();
        $results['pages'] = Pages::select('slug', 'updated_at')->orderByDesc('page_id')->get();
        $results['posts'] = Posts::select('slug', 'updated_at')->where('status', '!=', 'trash')->orderByDesc('post_id')->get();
        return $results;
    }
}
