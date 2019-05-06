<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
class Helper
{
    static function uniqImg($extension, $prefix = 'img_')
    {
        $uniq = uniqid($prefix);
        return $uniq . '.' . $extension;
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

    static function renderImages($images)
    {
        $view = view('rix.layouts.components.media.images', compact('images'))->render();
        return response()->json(['html' => $view]);
    }
}
