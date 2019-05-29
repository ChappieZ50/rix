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
    static $postID = 'a';

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
        // Other Way
        /*$records = ModelPosts::with([
            'termRelationships' => function ($query) {
                $query->join('rix_term_taxonomy', 'rix_term_relationships.term_taxonomy_id', '=', 'rix_term_taxonomy.term_taxonomy_id')
                    ->join('rix_terms', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
                    ->select('term_relationships_id','post_id','rix_terms.name','rix_terms.slug','rix_terms.term_id','rix_term_taxonomy.term_taxonomy_id','rix_term_taxonomy.taxonomy');
            }])->orderBy($options['orderByColumn'], $options['orderByType']);*/

        $records = !empty($options['wherePostColumn']) ? $records->where($options['wherePostColumn'], $options['wherePostValue']) : $records;
        $records = !empty($options['whereInPostColumn']) ? $records->whereIn($options['whereInPostColumn'], $options['whereInPostValue']) : $records;
        return $records;
    }

    static function getPostCount($column = '', $value = '')
    {
        return !empty($column) && !empty($value) ? ModelPosts::where($column, $value)->count() : ModelPosts::count();
    }

    static function renderPosts($viewData, $blade)
    {
        $view = view($blade)->with($viewData)->render();
        return response()->json(['html' => $view]);
    }

    static function getRenderedPosts($type = '')
    {
        $records = $type == 'open' || empty($type) ? self::getPosts(['whereInPostColumn' => 'status', 'whereInPostValue' => ['closed', 'open']]) : self::getPosts(['wherePostColumn' => 'status', 'wherePostValue' => $type]);
        $viewData = self::getViewData(['type' => $type]);
        $viewData['posts'] = $records->paginate(20);
        $posts = self::renderPosts($viewData, 'rix.layouts.components.posts.posts.posts-table');
        return $posts;
    }

    static function getViewData($custom = [])
    {
        $viewData = [
            'all'    => self::getPosts(['whereInPostColumn' => 'status', 'whereInPostValue' => ['closed', 'open']])->count(),
            'open'   => self::getPostCount('status', 'open'),
            'closed' => self::getPostCount('status', 'closed'),
            'trash'  => self::getPostCount('status', 'trash'),
            'type'   => ''
        ];
        if (!empty($custom))
            $viewData = array_merge($viewData, $custom);
        return $viewData;
    }

    static function getRenderedTablePagesBar($custom = [])
    {
        return self::renderPosts(self::getViewData($custom), 'rix.layouts.components.posts.posts.table-pages-bar');
    }

    static function toTrash($request)
    {
        $data = $request->input('data');
        if ($data) {
            foreach ($data as $item) {
                $update = ModelPosts::where('post_id', $item['id'])->update([
                    'status'        => 'trash',
                    'before_status' => $item['status']
                ]);
                if (!$update)
                    return Helper::response(false, 'Bazı Yazılar Çöpe Taşınamadı');
            }
            return ['posts' => Posts::getRenderedPosts($request->input('currentType')), 'tableBar' => Posts::getRenderedTablePagesBar(['type' => $request->input('currentType')])];

        }
    }

    static function deletePermanently($request)
    {
        $data = is_array($request->input('data')) ? $request->input('data') : [$request->input('data')];
        if (ModelPosts::destroy($data))
            return ['posts' => Posts::getRenderedPosts($request->input('currentType')), 'tableBar' => Posts::getRenderedTablePagesBar(['type' => $request->input('currentType')])];

        return Helper::response(false, 'Silinemedi');
    }

    static function restorePost($request)
    {
        $data = is_array($request->input('data')) ? $request->input('data') : [$request->input('data')];
        foreach ($data as $id) {
            $beforeStatus = ModelPosts::where('post_id', $id)->select('before_status')->first();
            if (!ModelPosts::where('post_id', $id)->update(['status' => !empty($beforeStatus) ? $beforeStatus->before_status : 'closed', 'before_status' => null]))
                return Helper::response(false, 'Bir Sorun Oluştu ve Bazı Yazılar Çöpten Taşınamadı');
        }
        return ['posts' => Posts::getRenderedPosts($request->input('currentType')), 'tableBar' => Posts::getRenderedTablePagesBar(['type' => $request->input('currentType')])];
    }

    static function ifExistsSlug($slug, $prefix = '-')
    {
        $i = 1;
        $constSlug = $slug;
        while (true) {
            if (ModelPosts::where('slug', $slug)->count() > 0) {
                $i++;
                $slug = $constSlug;
                $slug .= $prefix . $i;
            } else {
                break;
            }
        }
        return $i === 1 ? $constSlug : $slug;
    }

    static function findPostForUpdate($id)
    {
        $record = ModelPosts::with([
            'termRelationships' => function ($query) {
                $query->join('rix_term_taxonomy', 'rix_term_relationships.term_taxonomy_id', '=', 'rix_term_taxonomy.term_taxonomy_id')
                    ->join('rix_terms', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
                    ->select('post_id', 'rix_terms.term_id', 'rix_terms.name', 'rix_term_taxonomy.taxonomy');
            }])->where('post_id', $id)->first();
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
        $slug = self::ifExistsSlug(Str::slug($request->input('slug')));
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
        ];
        $data = array_merge($defaults, $data);
        return $data;
    }

    static function termRelations($request, $postID = '')
    {
        self::$postID = $postID;
        $tags = json_decode($request->input('tags'));
        $categories = $request->input('categories');
        if ($request->input('action') == 'update') {
            $tagIDS = [];
            foreach ($tags as $tag)
                if (isset($tag->id))
                    $tagIDS[] = $tag->id;

            TermRelationships::whereHas('posts', function ($query) {
                return $query->where('post_id', self::$postID);
            })->whereHas('termTaxonomy', function ($query) use ($tagIDS) {
                return $query->where('taxonomy', 'post_tag')->whereNotIn('term_id', $tagIDS);
            })->delete();

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
    }

    static function connectTerms($taxonomyID)
    {
        if (TermRelationships::where(['post_id' => self::$postID, 'term_taxonomy_id' => $taxonomyID])->count() <= 0)
            return TermRelationships::create([
                'post_id'          => self::$postID,
                'term_taxonomy_id' => $taxonomyID
            ]);
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
                'taxonomy' => 'post_tag'
            ]);
            if ($insert)
                return self::connectTerms($insert->term_taxonomy_id);

        }

        return false;
    }
}
