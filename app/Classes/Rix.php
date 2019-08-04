<?php

namespace App\Classes;

use App\Helpers\Helper;

class Rix
{
    CONST CACHE_KEY = 'RIX';

    private static function getRecords()
    {
        $records['post']  = \App\Models\Posts::count();
        $records['comment'] = \App\Models\Comments::count();
        $records['user'] = \App\Models\Users::count();
        $records['subscription'] = \App\Models\Subscriptions::count();
        return $records;
    }

    static function records()
    {

       /* if (Helper::cacheIsOn()) {
            $cacheKey = Helper::insertCacheKey(self::CACHE_KEY, 'INDEX');
            return \Cache::tags(self::CACHE_KEY)->remember($cacheKey, Helper::cacheTime(), function () {
                return self::getRecords();
            });
        }*/
        return self::getRecords();
    }
}