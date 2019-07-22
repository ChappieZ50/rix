<?php

namespace App\Http\Controllers\Rix\Posts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Gallery;
use App\Classes\Posts;
use App\Classes\CategoriesAndTags;
use App\Models\Posts as ModelPosts;

class PostsController extends Controller
{

    public function get_posts(Request $request)
    {
        if ($request->get('search')) {
            $records = Posts::getPosts()->whereIn('status', Posts::pageType($request->get('type')));
            $records = $records->paginate(20);
        }else{
            $records = Posts::paginate(20,$request->get('type'));
        }
        return view('rix.posts.posts')->with([
            'typeData' => Posts::getTypeData([ 'type' => $request->get('type') ]),
            'posts' => $records
        ]);
    }

    public function new_post(Request $request)
    {
        $images = Gallery::get_gallery([ 'image_id', 'image_name' ], config('definitions.NEW_POST_GALLERY_PAGINATE'));
        if ($request->ajax())
            return Helper::render($images, 'images', 'rix.layouts.component.media.images');
        $categories = CategoriesAndTags::getRecords([ 'taxonomy' => 'category', 'selectTerms' => [ 'term_id', 'name' ] ]);
        $tags = CategoriesAndTags::getRecords([ 'taxonomy' => 'post_tag', 'selectTerms' => [ 'term_id', 'name' ] ]);
        return view('rix.posts.post')->with([
            'images'      => $images,
            'parentItems' => $categories->get(),
            'tags'        => $tags->get()
        ]);
    }

    public function add_new_post(Request $request)
    {
        $validator = Posts::validatePost($request);
        if ($validator->isEmpty()) {
            $insert = ModelPosts::create(Posts::requestData($request));
            if ($insert) {
                $res = Posts::termRelations($request, $insert->post_id);
                return array_merge($res, [ 'post_id' => $insert->post_id ]);
            }
            return Helper::response(false, 'Bir sorun oluştu');
        }
        return Helper::response(false, '', [ 'errors' => $validator ]);
    }

    public function delete_post(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('action') == 'toTrash')
                return Posts::toTrash($request);
            elseif ($request->input('action') == 'deletePermanently')
                return Posts::deletePermanently($request);

        }
    }

    public function get_post(Request $request)
    {

        if ($request->get('action') == 'edit' && $request->get('id')) {
            $data = Posts::findPostForUpdate($request->get('id'));
            if (!empty($data)) {
                $images = Gallery::get_gallery([ 'image_id', 'image_name' ], config('definitions.NEW_POST_GALLERY_PAGINATE'));
                $categories = CategoriesAndTags::getRecords([ 'taxonomy' => 'category', 'selectTerms' => [ 'term_id', 'name' ] ]);
                $tags = CategoriesAndTags::getRecords([ 'taxonomy' => 'post_tag', 'selectTerms' => [ 'term_id', 'name' ] ]);

                return view('rix.posts.post')->with([
                    'images'      => $images,
                    'parentItems' => $categories->get(),
                    'tags'        => $tags->get(),
                    'post'        => $data
                ]);
            }
        }
        return redirect()->route('rix_posts');
    }

    public function update_post(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('action') == 'restore')
                return Posts::restorePost($request);
            if (!empty($request->input('id'))) {
                $validator = Posts::validatePost($request);
                if ($validator->isEmpty()) {
                    $updateData = Posts::requestData($request);
                    $update = ModelPosts::find($request->input('id'))->update($updateData);
                    Posts::clearCache($request->input('status') ? 'open' : 'closed');
                    if ($update) {
                        return Posts::termRelations($request, $request->input('id'));
                    } else {
                        return Helper::response(false, 'Bir sorun oluştu');
                    }
                }
                return Helper::response(false, '', [ 'errors' => $validator ]);
            }
            return Helper::response(false, 'Bir sorun oluştu');
        }
    }
}
