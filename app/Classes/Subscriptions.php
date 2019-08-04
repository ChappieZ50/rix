<?php

namespace App\Classes;

use App\Helpers\Helper;
use App\Models\Subscriptions as ModelSubscriptions;
use Illuminate\Support\Str;

class Subscriptions
{
    CONST CACHE_KEY = 'SUBSCRIPTIONS';

    static function getSubscriptions($options = [])
    {
        $defaults = [
            'whereColumn' => '',
            'whereValue'  => '',
            'order'       => 'created_at',
            'orderBy'     => 'desc',
        ];
        $options = array_merge($defaults, $options);
        $subscriptions = new ModelSubscriptions();
        if (!empty($options['whereColumn']) && !empty($options['whereValue'])) {
            $options['whereValue'] = !is_array($options['whereValue']) ? explode(',', $options['whereValue']) : $options['whereValue'];
            $subscriptions = $subscriptions->whereIn($options['whereColumn'], $options['whereValue']);
        }
        return $subscriptions->orderBy($options['order'], $options['orderBy']);
    }

    static function deleteSubscriptions($id)
    {
        $ids = Helper::getIds($id);
        $delete = ModelSubscriptions::destroy($ids);
        if ($delete)
            return Helper::response(true, 'Başarıyla Silindi');
        return Helper::response(false, 'Silme İşlemi Başarısız');
    }

    static function search($value)
    {
        return ModelSubscriptions::where(function ($query) use ($value) {
            return $query->where('email', 'like', '%' . $value . '%')
                ->orWhere('ip', 'like', '%' . $value . '%');
        })->orderByDesc('created_at');
    }

    static function paginate($request, $num)
    {
        if (Helper::cacheIsOn()) {
            $cacheKey = Helper::pageAutoCache(self::CACHE_KEY, $request->get('page'));
            return \Cache::tags(self::CACHE_KEY)->remember($cacheKey, Helper::cacheTime(), function () use ($num) {
                return self::getPaginateRecords($num);
            });
        }
        return self::getPaginateRecords($num);

    }

    static function insertSub($request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails())
            return Helper::response(false, '', ['errors' => $validator->errors()]);
        $insert = ModelSubscriptions::create([
            'email'         => $request->input('email'),
            'ip'            => $request->ip(),
            'readable_date' => Helper::readableDateFormat(),
            'security'      => \Hash::make(Str::random(16)),
        ]);
        if ($insert)
            return Helper::response(true, 'Başarıyla abone oldunuz');

        return Helper::response(false);

    }

    private static function getPaginateRecords($num)
    {
        $records = Subscriptions::getSubscriptions();
        return $records->paginate($num);
    }
}