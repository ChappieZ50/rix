<?php

namespace App\Classes;

use Spatie\Sitemap\Sitemap as SpatieSiteMap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\SitemapGenerator;

class SiteMap
{
    private static $siteMap = 'sitemap.xml';

    public function __construct($siteMap = null)
    {
        if (!empty($siteMap))
            self::$siteMap = $siteMap;
    }

    public static function removeLink($segment, $slug, $url = '')
    {
        SitemapGenerator::create($url)
            ->hasCrawled(function (Url $url) use ($segment, $slug) {
                if ($url->segment($segment) === $slug)
                    return;
                return $url;
            })
            ->writeToFile(self::$siteMap);
    }

    public static function addLink($slug, $lastModificationDate, $url = 'http://localhost:8000/')
    {
        SitemapGenerator::create($url)->getSitemap()->add(Url::create($slug)->setLastModificationDate($lastModificationDate)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.8)
        )->writeToFile(self::$siteMap);
    }
}