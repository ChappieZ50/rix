<?php

namespace App\Http\Controllers\Rix;

use App\Helpers\Helper;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function get_posts()
    {
        return view('rix.blog.posts');
    }

    public function new_post(Request $request)
    {
        $images = Gallery::get_gallery(['id', 'image_name'], config('definitions.NEW_POST_GALLERY_PAGINATE'));
        if ($request->ajax())
            return Helper::renderImages($images);
        return view('rix.blog.new_post', compact('images'));
    }

    public function add_new_post(Request $request)
    {
        $validate = [
            'title'           => 'required|max:255',
            'slug'            => 'required|max:255',
            'content'         => 'required',
            'summary'         => 'required',
            'seo_title'       => 'required|max:255',
            'seo_description' => 'required',
            'seo_keywords'    => 'nullable',
            'featured_image'  => 'required',
            'status'          => 'required',
            'categories'      => 'required',
            'tags'            => 'required',
        ];
        $validator = \Validator::make($request->all(), $validate);
        if ($validator->fails())
            return ['status' => false, 'errors' => $validator->errors()];
        else
            return ['status' => true, 'message' => $request->all()];
    }
}
