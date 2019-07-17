<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Sitemap as ClassesSitemap;
class SitemapController extends Controller
{
    public function index()
    {
        ClassesSitemap::create();
        /* if (!Cache::has('siteMap'))
             $this->create('');
         Cache::put('siteMap', true, now()->addMinutes(30));*/
        return redirect('/sitemap.xml');
    }
}
