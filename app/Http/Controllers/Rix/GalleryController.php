<?php

namespace App\Http\Controllers\Rix;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{

    public function get_gallery(Request $request)
    {
        $paginate = $request->ajax() && $request->input('action') != 'forGallery' ? config('definitions.MODAL_GALLERY_PAGINATE') : config('definitions.GALLERY_PAGINATE');
        $images = Gallery::get_gallery([ 'image_id', 'image_name', 'image_data', 'created_at' ], $paginate);
        if ($request->ajax()) {
            $blade = $request->input('action') == 'forGallery' ? 'rix.layouts.components.media.gallery-images' : 'rix.layouts.components.images';
            return Helper::render($images, 'images', $blade);
        }
        return view('rix.media.gallery', compact('images'));
    }

    public function new_media(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:3072',
            ]);
            $file = $request->file('image');
            $noExtensionName = Helper::uniqImg();
            $imageName = Helper::uniqImg([ 'extension' => $file->getClientOriginalExtension() ], $noExtensionName);
            $imageData = Helper::getImageData($file, $imageName, $noExtensionName);
            $upload = $file->move(public_path(config('definitions.PUBLIC_PATH')), $imageName);
            if ($upload) {
                $insert = Gallery::create([
                    'image_name' => $imageName,
                    'image_data' => $imageData
                ]);
                if (!$insert) {
                    File::delete(public_path(config('definitions.PUBLIC_PATH') . $imageName));
                    return [ 'status' => false, 'message' => 'Yükleme Başarısız' ];
                }
                return [ 'status' => true, 'message' => 'Yükleme Başarılı', 'data' => $insert ];
            } else {
                return [ 'status' => false, 'message' => 'Yükleme Başarısız' ];

            }
        }
        return view('rix.media.new_media');
    }

    public function delete_image(Request $request)
    {
        $image_id = $request->input('image_id');
        $images = Gallery::select([ 'image_id', 'image_name' ]);
        $images = is_array($image_id) ? $images->whereIn('image_id', $image_id)->get()->toArray() : $images->where('image_id', $image_id)->get()->toArray();
        if (Helper::deleteImage($images)) {
            if (Gallery::destroy($image_id))
                return [ 'status' => true, 'message' => 'Resim Silindi' ];
        }
        return [ 'status' => false, 'message' => 'Resim Silinemedi' ];

    }

    public function update_media(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->input('data');
            $id = $request->input('id');
            if (Gallery::where('image_id', $id)->update([ 'image_data' => $data ]))
                return Helper::response(true, 'Başarıyla Güncellendi');
        }
        return Helper::response(false, 'Güncelleme Başarısız');
    }
}
