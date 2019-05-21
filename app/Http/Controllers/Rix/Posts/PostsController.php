<?php

namespace App\Http\Controllers\Rix\Posts;

use App\Models\Terms\TermRelationships;
use App\Models\Terms\Terms;
use App\Models\Terms\TermTaxonomy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Gallery;
use App\Classes\Posts;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function get_posts()
    {
        return view('rix.posts.posts');
    }

    public function new_post(Request $request)
    {
        $images = Gallery::get_gallery(['id', 'image_name'], config('definitions.NEW_POST_GALLERY_PAGINATE'));
        if ($request->ajax())
            return Helper::render($images, 'images', 'rix.layouts.component.media.images');
        $categories = Posts::getRecords(['taxonomy' => 'category', 'selectTerms' => ['term_id', 'name']]);
        $tags = Posts::getRecords(['taxonomy' => 'post_tag', 'select' => ['rix_terms.term_id', 'rix_terms.name']]);
        return view('rix.posts.post_new')->with([
            'images'     => $images,
            'parentItems' => $categories->get(),
            'tags'       => $tags
        ]);
    }

    /**
     * @param Request $request
     * @return array|false|string
     */
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
            'tags'            => 'required',
        ];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $slug = $this->ifExistsSlug(Str::slug($request->input('slug')));
            $createPost = [
                'title'           => $request->input('title'),
                'slug'            => $slug,
                'content'         => json_encode($request->input('content')),
                'summary'         => $request->input('summary'),
                'seo_title'       => $request->input('seo_title'),
                'seo_description' => $request->input('seo_description'),
                'seo_keywords'    => $request->input('seo_keywords'),
                'featured_image'  => $request->input('featured_image'),
                'status'          => $request->input('status'),
                'featured'        => $request->input('featured'),
                'slider'          => $request->input('slider'),
                'url'             => url('/' . $slug),
                'readable_date'   => Helper::readableDateFormat(),
            ];
            $insert = \App\Models\Posts::create($createPost);
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
                            $this->connectTerm($tag, $insert->post_id);
                    }
                }
                return Helper::response(true, '');
            }
        }
        return Helper::response(false, '', ['errors' => $validator->errors()]);
    }

    private function connectTerm($tag, $postID, $justConnect = false, $id = '')
    {

        if (!$justConnect) {
            $term = \DB::table('rix_terms')
                ->join('rix_term_taxonomy', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
                ->where([
                    'rix_term_taxonomy.taxonomy' => 'post_tag',
                    'rix_terms.name'             => $tag['value']
                ])
                ->orWhere('rix_term_taxonomy.taxonomy', 'post_tag')
                ->where('rix_terms.slug', Str::slug($tag['value']))
                ->select('rix_term_taxonomy.term_taxonomy_id')
                ->first();
            if (!empty($term))
                return TermRelationships::create(['post_id' => $postID, 'term_taxonomy_id' => $term->term_taxonomy_id]);
            else
                return $this->insertTerm($tag, $postID);
        }
        return TermRelationships::create(['post_id' => $postID, 'term_taxonomy_id' => $id]);
    }

    private function insertTerm($tag, $postID)
    {
        $insert = Terms::create([
            'name'          => $tag['value'],
            'slug'          => Str::slug($tag['value']),
            'readable_date' => Helper::readableDateFormat(),
        ]);
        if ($insert) {
            $done = TermTaxonomy::create(['term_id' => $insert->term_id, 'taxonomy' => 'post_tag']);
            if ($done)
                return $this->connectTerm($tag, $postID, true, $done->term_taxonomy_id);
        }
        return false;
    }

    private function ifExistsSlug($slug, $prefix = '-')
    {
        $i = 1;
        $constSlug = $slug;
        while (true) {
            if (\App\Models\Posts::where('slug', $slug)->count() > 0) {
                $i++;
                $slug = $constSlug;
                $slug .= $prefix . $i;
            } else {
                break;
            }
        }
        return $i === 1 ? $constSlug : $slug;
    }
}
