<?php

namespace App\Helpers;

use App\Classes\Settings;
use Carbon\Carbon;
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

    static function deleteImage($images, $path = '')
    {
        $path = empty($path) ? config('definitions.PUBLIC_PATH') . '/' : $path;
        if (is_array($images) && !empty($images)) {
            foreach ($images as $image)
                File::delete($path . $image['image_name']);
            return true;
        } else {
            return false;
        }
    }

    static function render($data, $variable, $blade)
    {
        $view = view($blade)->with($variable, $data)->render();
        return response()->json([ 'html' => $view, 'data' => $data ]);
    }


    static function readableDateFormat($localized = '%d %B %Y')
    {
        $datetime = Carbon::createFromDate(date('Y-m-d H:i:s'));
        setlocale(LC_TIME, 'tr_TR.utf8');
        return $datetime->formatLocalized($localized);
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

    static function slugPrefix($slug, $table, $options = [])
    {
        $defaults = [
            'prefix'     => '-',
            'table'      => '',
            'slugColumn' => 'slug',
            'idColumn'   => '',
            'id'         => ''
        ];
        $options = array_merge($defaults, $options);
        $i = 1;
        $constSlug = $slug;
        while (true) {
            $item = empty($options['id']) || empty($options['idColumn']) ? $table->where($options['slugColumn'], $slug)->count() :
                $table->whereNotIn($options['idColumn'], is_array($options['id']) ? $options['id'] : explode(',', $options['id']))
                    ->where($options['slugColumn'], $slug)
                    ->count();
            if ($item > 0) {
                $i++;
                $slug = $constSlug;
                $slug .= $options['prefix'] . $i;
            } else {
                break;
            }
        }
        return $i === 1 ? $constSlug : $slug;
    }

    static function response($status, $message = '', $options = [])
    {
        $defaults = [
            'json'   => false,
            'custom' => [],
            'errors' => '',
        ];
        $options = array_merge($defaults, $options);
        $send = [ 'status' => $status, 'message' => $message ];
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
                $params = [ 'action' => 'edit', 'id' => $term->termTaxonomy->term_id ];
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
            'len'   => 50,
            'start' => 0,
        ];

        $options = array_merge($defaults, $options);
        return strlen($str) > $options['len'] ? substr($str, $options['start'], $options['len']) . "..." : $str;
    }

    static function findStatusOnParam($status, $types)
    {
        if (in_array($status, $types))
            return [ 'whereValue' => $status ];
        return [];
    }

    static function getIds($items)
    {
        $ids = [];
        if (is_array($items) || is_object($items)) {
            foreach ($items as $item) {
                $item = (object)$item;
                $ids[] = isset($item->id) ? $item->id : null;
            }
        }
        return $ids;
    }

    static function getImageData($file, $imageName, $noExtensionName, $encode = true)
    {
        $data = [
            'width'                  => getimagesize($file)[0],
            'height'                 => getimagesize($file)[1],
            'mime-type'              => $file->getClientMimeType(),
            'size'                   => $file->getSize(),
            'extension'              => $file->getClientOriginalExtension(),
            'url'                    => Helper::srcImage($imageName),
            'formatedDate'           => Helper::readableDateFormat(),
            'noExtensionName'        => $noExtensionName,
            'imageSizeHumanReadable' => Helper::fileSize($file->getSize()),
            'image_title'            => '',
            'image_alt'              => ''
        ];
        return $encode ? json_encode($data) : $data;
    }

    static function createTablePagesBar($typeData, $names, $routeName, $param = 'type', $render = true)
    {
        $type = $typeData->type;
        unset($typeData->type);
        $html = [];
        foreach ($typeData as $key => $value) {
            $aClass = 'nav-link';
            $spanClass = 'badge badge-primary';
            $href = $key !== 'all' ? route($routeName, [ $param => $key ]) : route($routeName);
            if ($type === $key) {
                $aClass = 'nav-link active';
                $spanClass = 'badge badge-white';
            } elseif (empty($type)) {
                $aClass = 'nav-link active';
                $spanClass = 'badge badge-white';
                $type = 'temp';
            }
            $namesKey = isset($names->$key) ? $names->$key : null;
            $html[] = '<li class="nav-item">';
            $html[] = '<a class="' . $aClass . '" href="' . $href . '">' . $namesKey . '';
            $html[] = '<span class="' . $spanClass . '">' . $value . '</span>';
            $html[] = '</a>';
            $html[] = ' </li>';
        }
        $typeData->type = $type;
        if (!$render)
            return $html;
        foreach ($html as $item)
            echo $item;
    }

    static function createSettingPagesBar($types, $routeName, $param = 'setting', $render = true)
    {
        $html = [];
        foreach ($types as $key => $value) {
            $html[] = '<li class="nav-item">';
            $active = null;
            if (!array_key_exists(\Request::get($param), $types)) {
                $first = array_key_first($types);
                if ($first == $key)
                    $active = 'active';
                $html[] = '<a href="' . route($routeName, [ $param => $key ]) . '" class="nav-link ' . $active . '">' . $value . '</a>';
            } else {
                if ($key == \Request::get($param))
                    $active = 'active';
                $html[] = '<a href="' . route($routeName, [ $param => $key ]) . '" class="nav-link ' . $active . '">' . $value . '</a>';
                $html[] = '</li>';
            }
        }
        if (!$render)
            return $html;
        foreach ($html as $item)
            echo $item;
    }

    static function getTimeDiff($time2, $time1 = null, $output = true)
    {
        $time1 = empty($time1) ? date('Y-m-d H:i:s') : $time1;
        $time = Carbon::parse($time1);
        $date = $time->diff(Carbon::parse($time2));
        if ($output === false)
            return $date;

        return $date->m . " Ay " . $date->d . " Gün " . $date->h . " Saat " . $date->i . " Dakika " . $date->s . " Saniye ";
    }

    static function recaptchaRequirements($requirement = 'status_recaptcha', $equal = null)
    {
        $setting = self::getSetting('security');
        if (!isset($setting->status_recaptcha) || $setting->status_recaptcha != 1)
            return false;
        else if (!isset($setting->$requirement) || $setting->$requirement != $equal)
            return false;
        else
            return true;
    }

    static function recaptchaIsHave()
    {
        if (config('recaptcha.site_key') != null || config('recaptcha.secret_key') != null)
            return true;
        return false;
    }

    static function getSetting($type, $param = null)
    {
        $setting = Settings::getSetting($type, !empty($param) ? $param : $type)->first();
        return isset($setting->$type) ? json_decode($setting->$type) : $setting;
    }

    static function insertCacheKey($current, $key, $value = null)
    {
        $key = strtoupper($key);
        if (!empty($value))
            $key .= "_$value";
        return $current . ".$key";
    }

    static function getCacheKey($cacheKey, $key)
    {
        $key = strtoupper($key);
        return $cacheKey . ".$key";
    }

    static function clearCache(...$cacheKey)
    {
        if (\Cache::tags($cacheKey))
            \Cache::tags($cacheKey)->flush();
    }

    static function pageAutoCache($key, $value, $type = 'page')
    {
        if (!empty($value) && is_numeric($value))
            return self::insertCacheKey($key, $type, $value);
        return $key;
    }

    static function getPageType($type, $types, $default = 'all')
    {
        if (in_array($type, $types))
            return $type;
        return $default;
    }

    static function cacheTime($default = 30, $doCarbon = true)
    {
        $setting = Settings::getSetting('cache', 'cache')->first();
        if (!empty($setting) && isset($setting->cache)) {
            $cache = json_decode($setting->cache);
            if (!empty($cache->cache_refresh_time))
                $default = $cache->cache_refresh_time;
        }
        if ($doCarbon)
            return Carbon::now()->addMinutes($default);
        return $default;
    }
}
