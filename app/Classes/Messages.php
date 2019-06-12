<?php
/**
 * Created by PhpStorm.
 * User: ugur
 * Date: 12.06.2019
 * Time: 11:22
 */

namespace App\Classes;

use App\Models\Messages as ModelMessages;

class Messages
{
    static function getMessages($options = [])
    {
        $defaults = [
            'whereColumn' => 'status',
            'whereValue'  => ['read', 'unread'],
            'order'       => 'created_at',
            'orderBy'     => 'desc',
        ];
        $options  = array_merge($defaults, $options);
        $messages = new ModelMessages();
        if (!empty($options['whereColumn']) && !empty($options['whereValue'])) {
            $options['whereValue'] = !is_array($options['whereValue']) ? explode(',', $options['whereValue']) : $options['whereValue'];
            $messages              = $messages->whereIn($options['whereColumn'], $options['whereValue']);
        }
        return $messages->orderBy($options['order'], $options['orderBy']);
    }

    static function getTypeData($custom = [])
    {
        $all      = ['whereColumn' => 'status', 'whereValue' => ['read', 'unread']];
        $unread   = ['whereColumn' => 'status', 'whereValue' => 'unread'];
        $trash    = ['whereColumn' => 'status', 'whereValue' => 'trash'];
        $read     = ['whereColumn' => 'status', 'whereValue' => 'read'];
        $typeData = [
            'all'    => self::getMessages($all)->count(),
            'unread' => self::getMessages($unread)->count(),
            'trash'  => self::getMessages($trash)->count(),
            'read'   => self::getMessages($read)->count()
        ];
        if (!empty($custom))
            $typeData = array_merge($typeData, $custom);
        return (object)$typeData;
    }

    static function getMessagesWithCount($options = [], $custom = [])
    {

        $count    = self::getTypeData($custom);
        $messages = self::getMessages($options);
        return [
            'messages' => $messages,
            'count'    => $count
        ];
    }
}