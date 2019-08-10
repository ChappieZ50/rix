<?php

namespace App\Classes;

use App\Helpers\Helper;

class Rix
{
    CONST CACHE_KEY = 'RIX';

    private static function getRecords()
    {
        if (\Auth::user()->role === 'admin') {
            $records['messages'] = \App\Models\Messages::where('status', '!=', 'trash')->select('message_id', 'name', 'email', 'subject', 'message')->orderByDesc('message_id')->take(6)->get();
            $records['users'] = \App\Models\Users::where('status', '!=', 'banned')->select('user_id', 'name', 'username', 'avatar', 'role')->orderByDesc('user_id')->take(6)->get();
        }
        $records['count_post'] = \App\Models\Posts::count();
        $records['count_comment'] = \App\Models\Comments::count();
        $records['count_user'] = \App\Models\Users::count();
        $records['count_subscription'] = \App\Models\Subscriptions::count();
        $records['comments'] = \App\Models\Comments::where('status', '!=', 'spam')->select('comment_id', 'name', 'email', 'comment')->orderByDesc('comment_id')->take(6)->get();
        return $records;
    }

    static function records()
    {

        if (Helper::cacheIsOn()) {
            $cacheKey = Helper::insertCacheKey(self::CACHE_KEY, 'INDEX');
            return \Cache::tags(self::CACHE_KEY)->remember($cacheKey, Helper::cacheTime(5), function () {
                return self::getRecords();
            });
        }
        return self::getRecords();
    }
}