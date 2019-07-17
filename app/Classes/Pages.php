<?php
/**
 * Created by PhpStorm.
 * User: chappie
 * Date: 25.06.2019
 * Time: 20:40
 */

namespace App\Classes;


use App\Events\SiteMapCrud;
use App\Helpers\Helper;
use App\Models\Pages as ModelPages;
use Illuminate\Support\Str;

class Pages
{


    static function validatePage($request, $validate = [])
    {
        $defaultValidate = [
            'title'           => 'required|max:255',
            'slug'            => 'required|max:255',
            'content'         => 'required',
            'seo_keywords'    => 'nullable',
            'seo_title'       => 'required|max:255',
            'seo_description' => 'required',
            'status'          => 'nullable',
            'registered'      => 'nullable',
            'featured_image'  => 'nullable',
        ];
        $validate = array_merge($defaultValidate, $validate);
        $validator = \Validator::make($request->all(), $validate);
        return $validator->errors();
    }

    static function requestData($request)
    {
        if ($request->input('id'))
            $slug = Helper::slugPrefix(Str::slug($request->input('slug')), new ModelPages(), [ 'idColumn' => 'page_id', 'id' => $request->input('id') ]);
        else
            $slug = Helper::slugPrefix(Str::slug($request->input('slug')), new ModelPages());
        return [
            'title'           => $request->input('title'),
            'slug'            => $slug,
            'content'         => json_encode($request->input('content')),
            'seo_keywords'    => $request->input('seo_keywords'),
            'seo_title'       => $request->input('seo_title'),
            'seo_description' => $request->input('seo_description'),
            'status'          => $request->input('status') ? 1 : 0,
            'registered'      => $request->input('registered') ? 1 : 0,
            'featured_image'  => $request->input('featured_image'),
            'readable_date'   => Helper::readableDateFormat()
        ];
    }

    static function createPage($request)
    {
        $validator = self::validatePage($request);
        if ($validator->isNotEmpty())
            return Helper::response(false, '', [ 'errors' => $validator ]);
        $create = ModelPages::create(self::requestData($request));
        if ($create){
            return Helper::response(true, 'Eklendi', [ 'custom' => [ 'page_id' => $create->page_id, 'action' => 'insert' ] ]);
        }
        return Helper::response(false);

    }

    static function updatePage($request)
    {
        $validator = self::validatePage($request);
        if ($validator->isNotEmpty())
            return Helper::response(false, '', [ 'errors' => $validator ]);
        $update = ModelPages::find($request->input('id'))->update(self::requestData($request));
        if ($update){
            return Helper::response(true, 'Güncellendi', [ 'custom' => [ 'page_id' => $request->input('id'), 'action' => 'update' ] ]);
        }
        return Helper::response(false);
    }

    static function actionPages($request)
    {
        $ids = Helper::getIds($request->input('data'));
        if ($request->input('action') === 'delete' && !empty($ids))
            return ModelPages::destroy($ids);
    }
}