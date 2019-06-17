<?php

namespace App\Classes;

use App\Helpers\Helper;
use App\Models\Subscriptions as ModelSubscriptions;

class Subscriptions
{
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
        if($delete)
            return Helper::response(true,'Başarıyla Silindi');
        return Helper::response(false,'Silme İşlemi Başarısız');
    }
}