<?php

namespace App\Classes;

use App\Models\Gallery;
use App\Models\Posts as ModelPosts;
use App\Models\Terms\Terms;
use App\Models\Terms\TermRelationships;
use App\Models\Terms\TermTaxonomy;
use App\Helpers\Helper;
use Illuminate\Support\Str;

class Posts
{
    static $postID;
    static protected $pageTypes = [
        'open',
        'closed',
        'trash',
    ];

    CONST CACHE_KEY = 'POSTS';

    static function getPosts($options = [])
    {
        $defaults = [
            'wherePostColumn'   => '',
            'wherePostValue'    => '',
            'orderByColumn'     => 'created_at',
            'orderByType'       => 'desc',
            'whereInPostColumn' => '',
            'whereInPostValue'  => '',
        ];
        $options = array_merge($defaults, $options);
        $records = ModelPosts::with('termRelationships.termTaxonomy.terms')->orderBy($options['orderByColumn'], $options['orderByType']);
        $records = !empty($options['wherePostColumn']) ? $records->where($options['wherePostColumn'], $options['wherePostValue']) : $records;
        $records = !empty($options['whereInPostColumn']) ? $records->whereIn($options['whereInPostColumn'], $options['whereInPostValue']) : $records;
        return $records->with([
            'user'        => function ($query) {
                $query->where('status', 'ok')->select('user_id', 'username');
            }, 'comments' => function ($query) {
                $query->select('comment_id', 'post_id');
            } ]);
    }

    static function renderPosts($viewData, $blade)
    {
        $view = view($blade)->with($viewData)->render();
        return response()->json([ 'html' => $view ]);
    }

    static function getRenderedPosts($type = '')
    {
        $records = $type == 'open' || empty($type) ? self::getPosts([ 'whereInPostColumn' => 'status', 'whereInPostValue' => [ 'closed', 'open' ] ]) : self::getPosts([ 'wherePostColumn' => 'status', 'wherePostValue' => $type ]);
        $typeData = self::getTypeData([ 'type' => $type ]);
        $posts = self::renderPosts([ 'posts' => $records->paginate(20), 'typeData' => $typeData ], 'rix.layouts.components.posts.posts.table');
        return $posts;
    }

    static function getTypeData($custom = [])
    {
        $all = [ 'whereInPostColumn' => 'status', 'whereInPostValue' => [ 'closed', 'open' ] ];
        $open = [ 'wherePostColumn' => 'status', 'wherePostValue' => 'open' ];
        $closed = [ 'wherePostColumn' => 'status', 'wherePostValue' => 'closed' ];
        $trash = [ 'wherePostColumn' => 'status', 'wherePostValue' => 'trash' ];

        $typeData = [
            'all'    => self::getPosts($all)->count(),
            'open'   => self::getPosts($open)->count(),
            'closed' => self::getPosts($closed)->count(),
            'trash'  => self::getPosts($trash)->count(),
        ];
        if (!empty($custom))
            $typeData = array_merge($typeData, $custom);
        return (object)$typeData;
    }

    static function getRenderedTablePagesBar($custom = [])
    {
        return self::renderPosts([ 'typeData' => self::getTypeData($custom) ], 'rix.layouts.components.posts.posts.pages-bar');
    }

    static function toTrash($request)
    {
        $data = $request->input('data');
        if ($data) {
            foreach ($data as $item) {
                $update = ModelPosts::find($item['id'])->update([
                    'status'        => 'trash',
                    'before_status' => $item['status']
                ]);
                $taxonomy = TermTaxonomy::whereHas('termRelationships', function ($query) use ($item) {
                    return $query->whereHas('posts', function ($query) use ($item) {
                        return $query->where('post_id', $item['id']);
                    });
                })->select('term_taxonomy_id')->get();
                foreach ($taxonomy as $tax)
                    self::relationsCounter($tax->term_taxonomy_id, 'decrement');
                if (!$update)
                    return Helper::response(false, 'Bazı Yazılar Çöpe Taşınamadı');
            }
            return [ 'posts' => Posts::getRenderedPosts($request->input('currentType')), 'tableBar' => Posts::getRenderedTablePagesBar([ 'type' => $request->input('currentType') ]) ];

        }
    }

    static function deletePermanently($request)
    {
        $data = is_array($request->input('data')) ? $request->input('data') : [ $request->input('data') ];
        if (ModelPosts::destroy($data)) {
            return [ 'posts' => Posts::getRenderedPosts($request->input('currentType')), 'tableBar' => Posts::getRenderedTablePagesBar([ 'type' => $request->input('currentType') ]) ];
        }

        return Helper::response(false, 'Silinemedi');
    }

    static function restorePost($request)
    {
        $data = is_array($request->input('data')) ? $request->input('data') : [ $request->input('data') ];
        foreach ($data as $id) {
            $beforeStatus = ModelPosts::where('post_id', $id)->select('before_status')->first();
            $taxonomy = TermTaxonomy::whereHas('termRelationships', function ($query) use ($id) {
                return $query->whereHas('posts', function ($query) use ($id) {
                    return $query->where('post_id', $id);
                });
            })->select('term_taxonomy_id')->get();
            foreach ($taxonomy as $tax)
                self::relationsCounter($tax->term_taxonomy_id, 'increment');
            if (!ModelPosts::find($id)->update([ 'status' => !empty($beforeStatus) ? $beforeStatus->before_status : 'closed', 'before_status' => null ]))
                return Helper::response(false, 'Bir Sorun Oluştu ve Bazı Yazılar Çöpten Taşınamadı');
        }
        return [ 'posts' => Posts::getRenderedPosts($request->input('currentType')), 'tableBar' => Posts::getRenderedTablePagesBar([ 'type' => $request->input('currentType') ]) ];
    }

    static function findPostForUpdate($id)
    {
        $record = ModelPosts::with([
            'termRelationships' => function ($query) {
                $query->join('rix_term_taxonomy', 'rix_term_relationships.term_taxonomy_id', '=', 'rix_term_taxonomy.term_taxonomy_id')
                    ->join('rix_terms', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
                    ->select('post_id', 'rix_terms.term_id', 'rix_terms.name', 'rix_term_taxonomy.taxonomy');
            } ])->where('post_id', $id)->first();
        if (!empty($record)) {
            $featuredImage = Gallery::where('image_id', $record->featured_image)->first();
            if (!empty($featuredImage))
                $record->selected_featured_image = $featuredImage;
            return $record;
        }
        return false;

    }

    static function validatePost($request, $validate = [])
    {
        $defaultValidate = [
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
        $validate = array_merge($defaultValidate, $validate);
        $validator = \Validator::make($request->all(), $validate);
        return $validator->errors();
    }

    static function requestData($request, $data = [])
    {

        if ($request->input('action') == 'update')
            $slug = Helper::slugPrefix(Str::slug($request->input('slug')), new ModelPosts(), [ 'idColumn' => 'post_id', 'id' => $request->input('id') ]);
        else
            $slug = Helper::slugPrefix(Str::slug($request->input('slug')), new ModelPosts());
        $defaults = [
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
            'author_id'       => \Auth::user()->user_id
        ];
        $data = array_merge($defaults, $data);
        return $data;
    }

    static function fetchTerms($ids, $taxonomy = 'post_tag')
    {
        $term = TermRelationships::whereHas('posts', function ($query) {
            return $query->where('post_id', self::$postID);
        })->whereHas('termTaxonomy', function ($query) use ($ids, $taxonomy) {
            return $query->where('taxonomy', $taxonomy)->whereNotIn('term_id', $ids);
        });
        $taxonomyDecrement = $term->get();
        if (is_object($taxonomyDecrement)) {
            foreach ($taxonomyDecrement as $tax)
                TermTaxonomy::where('term_taxonomy_id', $tax->term_taxonomy_id)->decrement('count');
        }
        return $term->delete();
    }

    static function termRelations($request, $postID = '')
    {
        self::$postID = $postID;
        $tags = json_decode($request->input('tags'));
        $categories = $request->input('categories');
        if ($request->input('action') == 'update') {
            $tagIDS = [];
            if (!empty($tags)) {
                foreach ($tags as $tag)
                    if (isset($tag->id))
                        $tagIDS[] = $tag->id;
                self::fetchTerms($tagIDS);
                self::fetchTerms($categories, 'category');
            }

        }
        if (is_array($tags)) {
            foreach ($tags as $tag) {
                if (isset($tag->value)) {

                    $term = Terms::with('termTaxonomy')->whereHas('termTaxonomy', function ($query) use ($tag) {
                        $query->where('taxonomy', 'post_tag')->select('term_taxonomy_id');
                    })->select('term_id');
                    if (!isset($term->id))
                        $term = $term->where('name', $tag->value)->first();
                    else
                        $term = $term->where('term_id', $tag->id)->first();
                    if (!empty($term))
                        self::connectTerms($term->termTaxonomy->term_taxonomy_id);
                    else
                        self::insertTerms($tag);
                }
            }
        }
        if (is_array($categories)) {
            TermRelationships::whereHas('posts', function ($query) {
                return $query->where('post_id', self::$postID);
            })->whereHas('termTaxonomy', function ($query) use ($categories) {
                return $query->where('taxonomy', 'category')->whereNotIn('term_id', $categories);
            })->delete();
            foreach ($categories as $category) {
                $term = TermTaxonomy::where('term_id', $category)->select('term_taxonomy_id')->first();
                if (!empty($term))
                    self::connectTerms($term->term_taxonomy_id);
            }
        }
        return Helper::response(true);
    }

    static function connectTerms($taxonomyID)
    {
        if (TermRelationships::where([ 'post_id' => self::$postID, 'term_taxonomy_id' => $taxonomyID ])->count() <= 0) {
            self::relationsCounter($taxonomyID);
            return TermRelationships::create([
                'post_id'          => self::$postID,
                'term_taxonomy_id' => $taxonomyID
            ]);
        }
        return null;
    }

    static function insertTerms($tag)
    {
        if (isset($tag->value)) {
            $slug = Str::slug($tag->value);
            $term = new Terms();
            $term->name = $tag->value;
            $term->slug = $slug;
            $term->readable_date = Helper::readableDateFormat();
            $term->save();
            $insert = $term->termTaxonomy()->create([
                'taxonomy' => 'post_tag',
            ]);
            if ($insert)
                return self::connectTerms($insert->term_taxonomy_id);

        }

        return false;
    }

    static function relationsCounter($taxonomyID, $type = 'increment')
    {
        $taxonomy = TermTaxonomy::where('term_taxonomy_id', $taxonomyID);
        if ($type === 'increment')
            return $taxonomy->increment('count');
        else
            return $taxonomy->decrement('count');
    }

    static function search($value, $status)
    {
        $records = ModelPosts::where(function ($query) use ($value) {
            return $query->where('title', 'like', '%' . $value . '%')->orWhere('slug', 'like', '%' . Str::slug($value) . '%');
        })->whereIn('status', $status)
            ->orderBy('created_at', 'desc');
        return $records;
    }

    static function pageType($type)
    {
        if ($type != 'closed' && $type != 'trash' && $type != 'open')
            $type = [ 'closed', 'open' ];

        return !is_array($type) ? explode(',', $type) : $type;
    }

    static function paginate($num, $type, $page)
    {
        $key = Helper::getPageType($type, self::$pageTypes);
        $cacheKey = Helper::pageAutoCache(Helper::getCacheKey(self::CACHE_KEY, $key), $page);
        return \Cache::tags(self::CACHE_KEY)->remember($cacheKey, Helper::cacheTime(), function () use ($num, $type) {
            $records = self::getPosts()->whereIn('status', self::pageType($type));
            return $records->paginate($num);
        });
    }
}
