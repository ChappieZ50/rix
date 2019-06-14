<?php
/**
 * Created by PhpStorm.
 * User: ugur
 * Date: 12.06.2019
 * Time: 11:22
 */

namespace App\Classes;

use App\Helpers\Helper;
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
    static function doMessageAction($messages, $action)
    {
        $ids = Helper::getIds($messages);
        if ($action === 'read' || $action === 'unread') {
            $do = ModelMessages::whereIn('message_id', $ids)->update(['status' => $action, 'before_status' => null]);
        } elseif ($action === 'trash' || $action === 'untrash') {
            if (is_array($messages) || is_object($messages)) {
                foreach ($messages as $message) {
                    $get = ModelMessages::where('message_id', $message['id'])->first();
                    $do  = ModelMessages::where('message_id', $message['id'])->update([
                        'before_status' => $action === 'untrash' ? null : $message['status'],
                        'status'        => $action === 'untrash' && isset($get->before_status) ? $get->before_status : $action
                    ]);
                }
            }
        } elseif ($action === 'delete') {
            $do = ModelMessages::destroy($ids);
        }
        if (isset($do) && $do)
            return Helper::response(true, 'Başarıyla Güncellendi');
        return Helper::response(false, 'Bir sorun oluştu!');
    }
}