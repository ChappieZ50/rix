<?php

namespace App\Http\Controllers\Rix;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    public function get_gallery(Request $request)
    {
        $images = \App\Classes\Gallery::paginate($request);
        if ($request->ajax()) {
            $blade = $request->input('action') == 'forGallery' ? 'rix.layouts.components.media.gallery-images' : 'rix.layouts.components.images';
            return Helper::render($images, 'images', $blade);
        }
        return view('rix.media.gallery', compact('images'));
    }

    public function new_media(Request $request)
    {
        if ($request->isMethod('post'))
            return \App\Classes\Gallery::newMedia($request);
        return view('rix.media.new_media');
    }

    public function delete_image(Request $request)
    {
        return \App\Classes\Gallery::deleteMedia($request->input('image_id'));
    }

    public function update_media(Request $request)
    {
        if ($request->ajax())
            return \App\Classes\Gallery::updateMedia($request);
        return Helper::response(false, 'Güncelleme Başarısız');
    }
}
