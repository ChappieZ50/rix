<?php

namespace App\Classes;


use App\Models\Terms\Terms;
use Carbon\Carbon;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\SitemapIndex;
use App\Models\Posts;
use App\Models\Pages;
use Spatie\Sitemap\Tags\Url;

class Sitemap
{
    static function refresh()
    {
        return self::create();
    }

    static function refreshPosts()
    {
        return self::create('posts');
    }

    static function refreshPages()
    {
        return self::create('pages');
    }

    static function refreshTags()
    {
        return self::create('tags');
    }

    static function refreshCategories()
    {
        return self::create('categories');
    }


    static function create($type = '')
    {
        self::createSitemaps();
        $sitemap = new \Spatie\Sitemap\Sitemap();
        if (empty($type)) {
            foreach (self::getAll() as $key => $value)
                self::writeAllRecords($key, $value);
        } else {
            foreach (self::getOne($type) as $item) {
                $prefix = '';
                if ($type === 'tags')
                    $prefix = config('definitions.TAGS_PREFIX');
                else if ($type === 'categories')
                    $prefix = config('definitions.CATEGORIES_PREFIX');
                $frequency = $type === 'posts' ? Url::CHANGE_FREQUENCY_DAILY : Url::CHANGE_FREQUENCY_WEEKLY;
                $sitemap->add(Url::create($prefix . $item->slug)->setChangeFrequency($frequency));
            }
            if ($type === 'pages')
                $sitemap->add(Url::create('/')->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
            $sitemap->writeToFile(public_path(self::getSitemap($type)));
        }
        return true;
    }

    static function getSitemap($type)
    {
        if ($type === 'posts')
            return 'sitemap_posts.xml';
        else if ($type === 'pages')
            return 'sitemap_pages.xml';
        else if ($type === 'categories')
            return 'sitemap_categories.xml';
        else if ($type === 'tags')
            return 'sitemap_tags.xml';

    }

    static function createSitemaps()
    {
        if (!\File::exists(public_path('/sitemap.xml')))
            SitemapGenerator::create('/')->writeToFile('sitemap.xml');
        else if (!\File::exists(public_path('/sitemap_posts.xml')))
            SitemapGenerator::create('/')->writeToFile('sitemap_posts.xml');
        else if (!\File::exists(public_path('/sitemap_pages.xml')))
            SitemapGenerator::create('/')->writeToFile('sitemap_pages.xml');
        else if (!\File::exists(public_path('/sitemap_categories.xml')))
            SitemapGenerator::create('/')->writeToFile('sitemap_categories.xml');
        else if (!\File::exists(public_path('/sitemap_tags.xml')))
            SitemapGenerator::create('/')->writeToFile('sitemap_tags.xml');
        SitemapIndex::create()
            ->add('/sitemap_posts.xml')
            ->add('/sitemap_pages.xml')
            ->add('/sitemap_categories.xml')
            ->add('/sitemap_tags.xml')
            ->writeToFile('sitemap.xml');
    }

    static function getOne($type)
    {
        if ($type === 'posts') {
            return Posts::select('slug', 'updated_at')->where('status', '!=', 'trash')->orderByDesc('post_id')->get();
        } else if ($type === 'pages') {
            return Pages::select('slug', 'updated_at')->orderByDesc('page_id')->get();
        } else if ($type === 'tags') {
            return Terms::with([
                'termTaxonomy' => function ($query) {
                    return $query->select('term_id', 'taxonomy')->where('taxonomy', 'post_tag');
                } ])->select('slug', 'updated_at', 'term_id')->orderByDesc('term_id')->get();
        } else if ($type === 'categories') {
            return Terms::with([
                'termTaxonomy' => function ($query) {
                    return $query->select('term_id', 'taxonomy')->where('taxonomy', 'category');
                } ])->select('slug', 'updated_at', 'term_id')->orderByDesc('term_id')->get();
        }
    }

    static function getAll()
    {
        $results['categories'] = Terms::whereHas('termTaxonomy', function ($query) {
            return $query->where('taxonomy', 'category');
        })->select('slug', 'updated_at', 'term_id')->orderByDesc('term_id')->get();
        $results['tags'] = Terms::whereHas('termTaxonomy', function ($query) {
            return $query->where('taxonomy', 'post_tag');
        })->select('slug', 'updated_at', 'term_id')->orderByDesc('term_id')->get();
        $results['pages'] = Pages::select('slug', 'updated_at')->orderByDesc('page_id')->get();
        $results['posts'] = Posts::select('slug', 'updated_at')->where('status', '!=', 'trash')->orderByDesc('post_id')->get();
        return $results;
    }

    static function writeAllRecords($key, $items)
    {
        $sitemap = new \Spatie\Sitemap\Sitemap();
        $file = self::getSitemap($key);
        foreach ($items as $item) {
            $prefix = '';
            if ($key === 'tags')
                $prefix = config('definitions.TAGS_PREFIX');
            else if ($key === 'categories')
                $prefix = config('definitions.CATEGORIES_PREFIX');
            $frequency = $key === 'posts' ? Url::CHANGE_FREQUENCY_DAILY : Url::CHANGE_FREQUENCY_WEEKLY;
            $sitemap->add(Url::create($prefix . $item->slug)->setChangeFrequency($frequency));
        }
        if ($key === 'pages')
            $sitemap->add(Url::create('/')->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->writeToFile($file);
    }

    static function insert($loc, $lastmod, $xml, $changefreg = Url::CHANGE_FREQUENCY_DAILY, $prefix = null, $priority = 0.8)
    {
        self::createSitemaps();
        $file = public_path($xml);
        $xml = simplexml_load_file($file);
        $child = $xml->addChild('url');
        $child->addChild('loc', \url($prefix . $loc));
        $child->addChild('lastmod', Carbon::parse($lastmod)->toIso8601String());
        $child->addChild('changefreg', $changefreg);
        $child->addChild('priority', $priority);
        $xml->saveXML($file);
    }

    static function delete($slug, $xml, $prefix = null)
    {
        $file = public_path($xml);
        $xml = simplexml_load_file($file);
        $c = 0;
        foreach ($xml->children() as $key => $value) {
            if (url('') != $value->loc && $value->loc == url($prefix . $slug)) {
                unset($xml->url[$c]);
                break;
            }
            $c++;
        }
        $xml->saveXML($file);
    }
}