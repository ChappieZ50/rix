<?php

namespace App\Classes;

use App\Helpers\Helper;
use App\Models\Gallery as ModelGallery;

class Gallery
{
    CONST CACHE_KEY = 'IMAGES';

    static function validateMedia($request, $validate = [])
    {
        $defaultValidate = [
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:3072',
        ];
        $validate = array_merge($defaultValidate, $validate);
        $validator = \Validator::make($request->all(), $validate);
        return $validator->errors();
    }

    static function newMedia($request)
    {

        $validator = self::validateMedia($request);
        if ($validator->isNotEmpty())
            return Helper::response(false, '', [ 'errors' => $validator ]);

        $file = $request->file('image');
        $noExtensionName = Helper::uniqImg();
        $imageName = Helper::uniqImg([ 'extension' => $file->getClientOriginalExtension() ], $noExtensionName);
        $imageData = Helper::getImageData($file, $imageName, $noExtensionName);
        $upload = $file->move(public_path(config('definitions.PUBLIC_PATH')), $imageName);
        if ($upload) {
            $insert = ModelGallery::create([
                'image_name' => $imageName,
                'image_data' => $imageData
            ]);
            if (!$insert) {
                \File::delete(public_path(config('definitions.PUBLIC_PATH') . $imageName));
                return [ 'status' => false, 'message' => 'Yükleme Başarısız' ];
            }
            return [ 'status' => true, 'message' => 'Yükleme Başarılı', 'data' => $insert ];
        } else {
            return [ 'status' => false, 'message' => 'Yükleme Başarısız' ];
        }
    }

    static function updateMedia($request)
    {
        $data = $request->input('data');
        $id = $request->input('id');
        if (ModelGallery::find($id)->update([ 'image_data' => $data ]))
            return Helper::response(true, 'Başarıyla Güncellendi');
    }

    static function deleteMedia($imageID)
    {
        $images = ModelGallery::select([ 'image_id', 'image_name' ]);
        $images = is_array($imageID) ? $images->whereIn('image_id', $imageID)->get()->toArray() : $images->where('image_id', $imageID)->get()->toArray();
        if (Helper::deleteImage($images))
            if (ModelGallery::destroy($imageID))
                return [ 'status' => true, 'message' => 'Resim Silindi' ];
        return [ 'status' => false, 'message' => 'Resim Silinemedi' ];
    }

    static function paginate($request)
    {
        if (Helper::cacheIsOn()) {
            $cacheKey = Helper::pageAutoCache(self::CACHE_KEY, $request->get('page'));
            return \Cache::tags(self::CACHE_KEY)->remember($cacheKey, Helper::cacheTime(), function () use ($request) {
                return self::getPaginateRecords($request);
            });
        }
        return self::getPaginateRecords($request);
    }

    private static function getPaginateRecords($request)
    {
        $paginate = $request->ajax() && $request->input('action') != 'forGallery' ? config('definitions.MODAL_GALLERY_PAGINATE') : config('definitions.GALLERY_PAGINATE');
        return ModelGallery::select('image_id', 'image_name', 'image_data', 'created_at')->orderByDesc('image_id')->paginate($paginate);
    }
}
