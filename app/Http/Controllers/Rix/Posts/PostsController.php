<?php

namespace App\Http\Controllers\Rix\Posts;

use App\Models\Terms\TermRelationships;
use App\Models\Terms\TermTaxonomy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Gallery;
use App\Classes\Posts;
use App\Classes\CategoriesAndTags;
use Illuminate\Support\Str;
use App\Models\Posts as ModelPosts;

class PostsController extends Controller
{
    public function get_posts(Request $request)
    {
        $type = $request->get('type');
        $viewData = Posts::getViewData(['type' => $type]);
        if ($type == 'closed')
            $records = Posts::getPosts(['wherePostColumn' => 'status', 'wherePostValue' => 'closed']);
        elseif ($type == 'trash')
            $records = Posts::getPosts(['wherePostColumn' => 'status', 'wherePostValue' => 'trash']);
        else
            $records = Posts::getPosts(['whereInPostColumn' => 'status', 'whereInPostValue' => ['closed', 'open']]);

        $viewData['posts'] = $records->paginate(20);
        return view('rix.posts.posts')->with($viewData);
    }

    public function new_post(Request $request)
    {
        $images = Gallery::get_gallery(['image_id', 'image_name'], config('definitions.NEW_POST_GALLERY_PAGINATE'));
        if ($request->ajax())
            return Helper::render($images, 'images', 'rix.layouts.component.media.images');
        $categories = CategoriesAndTags::getRecords(['taxonomy' => 'category', 'selectTerms' => ['term_id', 'name']]);
        $tags = CategoriesAndTags::getRecords(['taxonomy' => 'post_tag', 'selectTerms' => ['term_id', 'name']]);
        return view('rix.posts.post')->with([
            'images'      => $images,
            'parentItems' => $categories->get(),
            'tags'        => $tags->get()
        ]);
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
            'featured_image'  => 'required|integer',
            'status'          => 'required|integer',
            'featured'        => 'integer',
            'slider'          => 'integer',
            'categories'      => 'required',
            'tags'            => 'required|notIn:[]',
        ];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $slug = Posts::ifExistsSlug(Str::slug($request->input('slug')));
            $createPost = [
                'title'           => $request->input('title'),
                'slug'            => $slug,
                'content'         => json_encode($request->input('content')),
                'summary'         => $request->input('summary'),
                'seo_title'       => $request->input('seo_title'),
                'seo_description' => $request->input('seo_description'),
                'seo_keywords'    => $request->input('seo_keywords'),
                'featured_image'  => $request->input('featured_image'),
                'status'          => $request->input('status') ? 'open' : 'closed',
                'featured'        => $request->input('featured'),
                'slider'          => $request->input('slider'),
                'url'             => url('/' . $slug),
                'readable_date'   => Helper::readableDateFormat(),
            ];
            $insert = ModelPosts::create($createPost);
            if ($insert) {
                // For Categories
                $categories = $request->input('categories');
                if (!empty($categories) && is_array($categories)) {
                    foreach ($categories as $category)
                        if (TermTaxonomy::where(['taxonomy' => 'category', 'term_taxonomy_id' => $category])->count() > 0)
                            TermRelationships::create(['post_id' => $insert->post_id, 'term_taxonomy_id' => $category]);
                }
                // For Tags
                $tags = json_decode($request->input('tags'), true);
                if (!empty($tags) && is_array($tags)) {
                    foreach ($tags as $tag) {
                        if (isset($tag['value']))
                            Posts::connectTerm($tag, $insert->post_id);
                    }
                }
                return Helper::response(true, '');
            }
        }
        return Helper::response(false, '', ['errors' => $validator->errors()]);
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
            /*print_r($data->toArray());
            die();*/
            $images = Gallery::get_gallery(['image_id', 'image_name'], config('definitions.NEW_POST_GALLERY_PAGINATE'));
            $categories = CategoriesAndTags::getRecords(['taxonomy' => 'category', 'selectTerms' => ['term_id', 'name']]);
            $tags = CategoriesAndTags::getRecords(['taxonomy' => 'post_tag', 'selectTerms' => ['term_id', 'name']]);
            return view('rix.posts.post')->with([
                'images'      => $images,
                'parentItems' => $categories->get(),
                'tags'        => $tags->get(),
                'post'        => $data
            ]);
        }
        return redirect()->route('rix_posts');
    }

    public function update_post(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('action') == 'restore')
                return Posts::restorePost($request);

        }
    }
}
