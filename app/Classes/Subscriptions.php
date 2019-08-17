<?php

namespace App\Classes;

use App\Helpers\Helper;
use App\Models\Subscriptions as ModelSubscriptions;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\AssignOp\Mod;

class Subscriptions
{
    CONST CACHE_KEY = 'SUBSCRIPTIONS';
    static protected $pageTypes = [
        'ok',
        'no',
    ];

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

    static function search($value,$type)
    {
        if ($type === 'all')
            $type = [ 'no', 'ok' ];
        if (!is_array($type))
            $type = explode(',', $type);
        return ModelSubscriptions::where(function ($query) use ($value) {
            return $query->where('email', 'like', '%' . $value . '%')
                ->orWhere('ip', 'like', '%' . $value . '%');
        })->whereIn('send',$type)->orderByDesc('created_at');
    }

    static function paginate($options, $num, $type, $page)
    {
        if (Helper::cacheIsOn()) {
            $key = Helper::getPageType($type, self::$pageTypes);
            $cacheKey = Helper::pageAutoCache(Helper::getCacheKey(self::CACHE_KEY, $key), $page);
            return \Cache::tags(self::CACHE_KEY)->remember($cacheKey, Helper::cacheTime(), function () use ($num, $type, $options) {
                return self::getPaginateRecords($options, $num);
            });
        }
        return self::getPaginateRecords($options, $num);

    }

    static function insertSubscriber($request)
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

    static function updateSubscriber($request)
    {
        $ids = Helper::getIds($request->input('data'));
        $action = $request->input('action');
        $do = ModelSubscriptions::findMany($ids);
        $do->each(function ($item) use ($action) {
            $item->update(['send' => $action === 'sub' ? 'ok' : 'no']);
        });
        if ($do)
            return Helper::response(true, 'Başarıyla Güncellendi');
        return Helper::response(false, 'Bir sorun oluştu!');
    }

    static function unSubscribe($token, $delete = false)
    {
        $subscriber = ModelSubscriptions::where('security', $token)->where('send', 'ok')->firstOrFail();
        if (!empty($subscriber)) {
            if ($delete)
                $subscriber = ModelSubscriptions::where('security', $token)->delete();
            else
                $subscriber = ModelSubscriptions::where('security', $token)->update(['send' => 'no']);
        }
        return $subscriber;
    }

    static function getTypeData($custom = [])
    {
        $subscriber = ['whereColumn' => 'send', 'whereValue' => 'ok'];
        $unsubscriber = ['whereColumn' => 'send', 'whereValue' => 'no'];
        $typeData = [
            'all' => self::getSubscriptions()->count(),
            'ok'  => self::getSubscriptions($subscriber)->count(),
            'no'  => self::getSubscriptions($unsubscriber)->count(),
        ];
        if (!empty($custom))
            $typeData = array_merge($typeData, $custom);
        return (object)$typeData;
    }

    private static function getPaginateRecords($options, $num)
    {
        $records = Subscriptions::getSubscriptions($options);
        return $records->paginate($num);
    }
}