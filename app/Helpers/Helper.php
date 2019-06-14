<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class Helper
{
    static function uniqImg($options = [], $uniq = '')
    {
        $defaults = [
            'prefix'    => 'img_',
            'extension' => '',
        ];
        $options = array_merge($defaults, $options);
        if (empty($uniq))
            return uniqid($options['prefix']);
        else
            return $uniq . "." . $options['extension'];
    }

    static function srcImage($img = '')
    {
        return url(config('definitions.PUBLIC_PATH') . '/' . $img);
    }

    static function deleteImage($images)
    {
        if (is_array($images) && !empty($images)) {
            foreach ($images as $image)
                File::delete(config('definitions.PUBLIC_PATH') . '/' . $image['image_name']);
            return true;
        } else {
            return false;
        }
    }

    static function render($data, $variable, $blade)
    {
        $view = view($blade)->with($variable, $data)->render();
        return response()->json(['html' => $view, 'data' => $data]);
    }


    static function readableDateFormat()
    {
        $months = __('date');
        $month = $months[date('m') - 1];
        return date('j ') . $month . date(' Y ');
    }

    static function fileSize($size)
    {
        if ($size >= 1073741824)
            $size = round($size / 1073741824) . " GB";
        elseif ($size >= 1048576)
            $size = round($size / 1048576) . " MB";
        elseif ($size >= 1024)
            $size = round($size / 1024) . " KB";
        else
            $size = $size . " B";
        return $size;
    }

    static function response($status, $message = '', $options = [])
    {
        $defaults = [
            'json'   => false,
            'custom' => [],
            'errors' => '',
        ];
        $options = array_merge($defaults, $options);
        $send = ['status' => $status, 'message' => $message];
        if (!$status)
            $send['errors'] = $options['errors'];

        if ($options['custom'] !== null)
            $send['content'] = $options['custom'];
        return $options['json'] ? json_encode($send) : $send;
    }

    static function write($value, $key)
    {
        if (!is_array($key))
            return isset($value->$key) ? $value->$key : '';
        foreach ($key as $item) {
            if (isset($value->$item))
                $value = $value->$item;

        }
        return $value;
    }

    static function getTerms($taxonomy, $terms)
    {
        $i = 0;
        foreach ($terms as $term) {
            if ($term->termTaxonomy->taxonomy == $taxonomy) {
                $params = ['action' => 'edit', 'id' => $term->termTaxonomy->term_id];
                $route = $taxonomy == 'category' ? route('rix_categories', $params) : route('rix_tags', $params);
                $i++;
                echo '<a href="' . $route . '" target="_blank">' . $term->termTaxonomy->terms->name . '</a>, ';
            }
        }
        return $i <= 0 ? '—' : null;
    }

    static function longText($str, $options = [])
    {
        $defaults = [
            'len' => 50,
            'start' => 0,
        ];

        $options = array_merge($defaults, $options);
        return strlen($str) > $options['len'] ? substr($str, $options['start'], $options['len']) . "..." : $str;
    }

    static function findStatusOnParam($status,$types)
    {
        if(in_array($status,$types))
            return ['whereValue' => $status];
        return [];
    }

    static function getIds($items){
        $ids = [];
        if (is_array($items) || is_object($items)) {
            foreach ($items as $item) {
                $item = (object) $item;
                $ids[] = $item->id;
            }
        }
        return $ids;
    }
}
