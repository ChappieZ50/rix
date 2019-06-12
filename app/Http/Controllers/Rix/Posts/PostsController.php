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
        $type = $request->get('type');
        $viewData = Posts::getViewData([ 'type' => $type ]);
        if ($request->get('search')) {
            $search = Posts::search($request->get('search'),Posts::pageType($request->get('type')));
            $viewData['posts'] = $search->paginate(1);
        } else {
            $records = Posts::getPosts([ 'whereInPostColumn' => 'status', 'whereInPostValue' => Posts::pageType($type) ]);
            $viewData['posts'] = $records->paginate(1);
        }
        return view('rix.posts.posts')->with($viewData);
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
            $createPost = Posts::requestData($request);
            $insert = ModelPosts::create($createPost);
            if ($insert)
                return Posts::termRelations($request, $insert->post_id);
            else
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
                    $update = ModelPosts::where('post_id', $request->input('id'))->update($updateData);
                    if ($update)
                        return Posts::termRelations($request, $request->input('id'));
                    else
                        return Helper::response(false, 'Bir sorun oluştu');
                }
                return Helper::response(false, '', [ 'errors' => $validator ]);
            }
            return Helper::response(false, 'Bir sorun oluştu');
        }
    }
}
