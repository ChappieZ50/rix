<?php

namespace App\Classes;

use App\Helpers\Helper;
use App\Models\Comments as ModelComments;

class Comments
{
    static function getTypeData($custom = [])
    {
        $all      = ['whereColumn' => 'status', 'whereValue' => ['approved', 'pending']];
        $pending  = ['whereColumn' => 'status', 'whereValue' => 'pending'];
        $spam     = ['whereColumn' => 'status', 'whereValue' => 'spam'];
        $approved = ['whereColumn' => 'status', 'whereValue' => 'approved'];

        if (isset($custom['post_id'])) {
            $all      = array_merge(['wherePostColumn' => 'post_id', 'wherePostValue' => $custom['post_id']], $all);
            $pending  = array_merge(['wherePostColumn' => 'post_id', 'wherePostValue' => $custom['post_id']], $pending);
            $spam     = array_merge(['wherePostColumn' => 'post_id', 'wherePostValue' => $custom['post_id']], $spam);
            $approved = array_merge(['wherePostColumn' => 'post_id', 'wherePostValue' => $custom['post_id']], $approved);
        }
        $typeData = [
            'all'      => self::getComments($all)->count(),
            'pending'  => self::getComments($pending)->count(),
            'spam'     => self::getComments($spam)->count(),
            'approved' => self::getComments($approved)->count()
        ];
        if (!empty($custom))
            $typeData = array_merge($typeData, $custom);
        return (object)$typeData;
    }

    static function getComments($options = [])
    {
        $defaults = [
            'whereColumn'     => 'status',
            'whereValue'      => ['approved', 'pending'],
            'with'            => '',
            'withSelect'      => '',
            'wherePostColumn' => '',
            'wherePostValue'  => '',
            'order'           => 'created_at',
            'orderBy'         => 'desc',
        ];
        $options  = array_merge($defaults, $options);
        $comments = new ModelComments();
        if (!empty($options['whereColumn']) && !empty($options['whereValue'])) {
            $options['whereValue'] = !is_array($options['whereValue']) ? explode(',', $options['whereValue']) : $options['whereValue'];
            $comments              = $comments->whereIn($options['whereColumn'], $options['whereValue']);
        }
        if (!empty($options['wherePostColumn']) && !empty($options['wherePostValue'])) {
            $comments = $comments->whereHas('post', function ($query) use ($options) {
                $options['wherePostValue'] = !is_array($options['wherePostValue']) ? explode(',', $options['wherePostValue']) : $options['wherePostValue'];
                return $query->whereIn($options['wherePostColumn'], $options['wherePostValue']);
            });
        }
        $comments = !empty($options['with']) ? $comments->with([$options['with'] => function ($query) use ($options) {
            return $query->select(!empty($options['withSelect']) ? $options['withSelect'] : ['*']);
        }]) : $comments;
        return $comments->whereHas('post',function ($query){
            return $query->where('status','!=','trash');
        })->orderBy($options['order'], $options['orderBy']);
    }

    static function getCommentsWithCount($options = [], $custom = [])
    {

        $count = self::getTypeData($custom);
        if (isset($custom['post_id']))
            $comments = self::getComments(array_merge(['wherePostColumn' => 'post_id', 'wherePostValue' => $custom['post_id']], $options));
        else
            $comments = self::getComments($options);
        return [
            'comments' => $comments,
            'count'    => $count
        ];
    }

    static function doCommentAction($comments, $action)
    {
        $ids = Helper::getIds($comments);
        if ($action === 'approved' || $action === 'pending') {
            $do = ModelComments::whereIn('comment_id', $ids)->update(['status' => $action, 'before_status' => null]);
        } elseif ($action === 'spam' || $action === 'unspam') {
            if (is_array($comments) || is_object($comments)) {
                foreach ($comments as $comment) {
                    $get = ModelComments::where('comment_id', $comment['id'])->first();
                    $do  = ModelComments::where('comment_id', $comment['id'])->update([
                        'before_status' => $action === 'unspam' ? null : $comment['status'],
                        'status'        => $action === 'unspam' && isset($get->before_status) ? $get->before_status : $action
                    ]);
                }
            }
        } elseif ($action === 'delete') {
            $do = ModelComments::destroy($ids);
        }
        if (isset($do) && $do)
            return Helper::response(true, 'Başarıyla Güncellendi');
        return Helper::response(false, 'Bir sorun oluştu!');
    }
}