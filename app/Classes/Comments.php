<?php

namespace App\Classes;

use App\Helpers\Helper;
use App\Models\Comments as ModelComments;

class Comments
{
    static protected $pageTypes = [
        'approved',
        'pending',
        'spam',
    ];

    CONST CACHE_KEY = 'COMMENTS';

    static function getTypeData($custom = [])
    {
        $all = [ 'whereColumn' => 'status', 'whereValue' => [ 'approved', 'pending' ] ];
        $pending = [ 'whereColumn' => 'status', 'whereValue' => 'pending' ];
        $spam = [ 'whereColumn' => 'status', 'whereValue' => 'spam' ];
        $approved = [ 'whereColumn' => 'status', 'whereValue' => 'approved' ];

        if (isset($custom['post_id'])) {
            $all = array_merge([ 'wherePostColumn' => 'post_id', 'wherePostValue' => $custom['post_id'] ], $all);
            $pending = array_merge([ 'wherePostColumn' => 'post_id', 'wherePostValue' => $custom['post_id'] ], $pending);
            $spam = array_merge([ 'wherePostColumn' => 'post_id', 'wherePostValue' => $custom['post_id'] ], $spam);
            $approved = array_merge([ 'wherePostColumn' => 'post_id', 'wherePostValue' => $custom['post_id'] ], $approved);
        }
        $typeData = [
            'all'      => self::getComments($all)->count(),
            'approved' => self::getComments($approved)->count(),
            'pending'  => self::getComments($pending)->count(),
            'spam'     => self::getComments($spam)->count(),
        ];
        if (!empty($custom))
            $typeData = array_merge($typeData, $custom);
        return (object)$typeData;
    }

    static function getComments($options = [])
    {
        $defaults = [
            'whereColumn'     => 'status',
            'whereValue'      => [ 'approved', 'pending' ],
            'with'            => '',
            'withSelect'      => '',
            'wherePostColumn' => '',
            'wherePostValue'  => '',
            'order'           => 'created_at',
            'orderBy'         => 'desc',
            'userSelect'      => [ 'user_id', 'name', 'username', 'email' ],
        ];
        $options = array_merge($defaults, $options);
        $comments = new ModelComments();
        if (!empty($options['whereColumn']) && !empty($options['whereValue'])) {
            $options['whereValue'] = !is_array($options['whereValue']) ? explode(',', $options['whereValue']) : $options['whereValue'];
            $comments = $comments->whereIn($options['whereColumn'], $options['whereValue']);
        }
        if (!empty($options['wherePostColumn']) && !empty($options['wherePostValue'])) {
            $comments = $comments->whereHas('post', function ($query) use ($options) {
                $options['wherePostValue'] = !is_array($options['wherePostValue']) ? explode(',', $options['wherePostValue']) : $options['wherePostValue'];
                return $query->whereIn($options['wherePostColumn'], $options['wherePostValue']);
            });
        }
        $comments = !empty($options['with']) ? $comments->with([
            $options['with'] => function ($query) use ($options) {
                return $query->select(!empty($options['withSelect']) ? $options['withSelect'] : [ '*' ]);
            } ]) : $comments;
        return $comments->whereHas('post', function ($query) {
            return $query->where('status', '!=', 'trash');
        })->with([
            'user' => function ($query) use ($options) {
                $query->select($options['userSelect']);
            } ])->orderBy($options['order'], $options['orderBy']);
    }

    static function doCommentAction($comments, $action)
    {
        $ids = Helper::getIds($comments);
        if ($action === 'approved' || $action === 'pending') {
            $do = ModelComments::findMany($ids);
            $do->each(function ($item) use ($action) {
                $item->update([ 'status' => $action, 'before_status' => null ]);
            });
        } elseif ($action === 'spam' || $action === 'unspam') {
            if (is_array($comments) || is_object($comments)) {
                foreach ($comments as $comment) {
                    $get = ModelComments::where('comment_id', $comment['id'])->first();
                    $do = ModelComments::find($comment['id'])->update([
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

    static function createComment($request)
    {
        $validate = [
            'parent_comment' => 'nullable|numeric',
            'message'        => 'required',
            'post_id'        => 'required'
        ];
        $data = [
            'comment'        => $request->input('message'),
            'ip'             => $request->ip(),
            'parent_comment' => $request->input('parent_comment'),
            'post_id'        => $request->input('post_id'),
            'readable_date'  => Helper::readableDateFormat()
        ];
        if (\Auth::check()) {
            $data += [ 'user_id' => \Auth::user()->user_id ];
        } else {
            $validate = $validate + [
                    'name'  => 'required',
                    'email' => 'required|email'
                ];
            $data += [
                'name'  => $request->input('name'),
                'email' => $request->input('email'),
            ];
        }
        $validator = \Validator::make($request->all(), $validate);
        if ($validator->fails())
            return Helper::response(false, '', [ 'errors' => $validator->errors() ]);

        if (ModelComments::create($data))
            return Helper::response(true, 'Yorum Gönderildi');
        return Helper::response(false, 'Bir Sorun Oluştu');
    }

    static function search($value, $type)
    {
        if ($type === 'all')
            $type = [ 'approved', 'pending' ];
        if (!is_array($type))
            $type = explode(',', $type);
        return ModelComments::where(function ($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%')
                ->orWhere('email', 'like', '%' . $value . '%')
                ->orWhere('comment', 'like', '%' . $value . '%');
        })->whereIn('status', $type)->orderByDesc('created_at');
    }

    static function pageType($type)
    {
        if ($type != 'approved' && $type != 'spam' && $type != 'pending')
            $type = [ 'approved', 'pending' ];

        return !is_array($type) ? explode(',', $type) : $type;
    }

    static function paginate($options, $num, $type, $page)
    {

        if (Helper::cacheIsOn()) {
            $key = Helper::getPageType($type, self::$pageTypes);
            $cacheKey = Helper::pageAutoCache(Helper::getCacheKey(self::CACHE_KEY, $key), $page);
            return \Cache::tags(self::CACHE_KEY)->remember($cacheKey, Helper::cacheTime(), function () use ($num, $type, $options) {
                return self::getPaginateRecords($options, $num, $type);
            });
        }
        return self::getPaginateRecords($options, $num, $type);
    }

    private static function getPaginateRecords($options, $num, $type)
    {
        $records = self::getComments($options)->whereIn('status', self::pageType($type));
        return $records->paginate($num);
    }
}