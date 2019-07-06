<?php

namespace App\Classes;


use App\Http\Controllers\SitemapController;

class Sitemap
{
    static function refresh()
    {
        $sitemap = new SitemapController();
        return $sitemap->create();
    }
}