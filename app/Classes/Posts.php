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

<<<<<<< HEAD
        $data = Terms::with('termTaxonomy')
            ->whereHas('termTaxonomy', function ($query) use ($options) {
                $query->where('taxonomy', $options['taxonomy'])
                    ->select($options['selectTermTaxonomy'])
                    ->orderBy($options['termTaxonomyOrder'], $options['order_type']);
            })
            ->select($options['selectTerms'])
            ->orderBy($options['termsOrder'], $options['order_type']);

        $data = $options['doPaginate'] ? $data->paginate($options['paginate']) : $data;
        $data = $options['get'] && !$options['doPaginate'] ? $data->get() : $data;
        return $options['response'] ? Helper::response(true) :$data;
=======
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
>>>>>>> f73c3a8cfe983a574607693d6783346fa0e87dd3
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
    static function restorePost($request){
        $data = is_array($request->input('data')) ? $request->input('data') : [$request->input('data')];
        foreach ($data as $id) {
            $beforeStatus = ModelPosts::where('post_id', $id)->select('before_status')->first();
            if (!ModelPosts::where('post_id', $id)->update(['status' => !empty($beforeStatus) ? $beforeStatus->before_status : 'closed', 'before_status' => null]))
                return Helper::response(false, 'Bir Sorun Oluştu ve Bazı Yazılar Çöpten Taşınamadı');
        }
        return ['posts' => Posts::getRenderedPosts($request->input('currentType')), 'tableBar' => Posts::getRenderedTablePagesBar(['type' => $request->input('currentType')])];
    }

    static function connectTerm($tag, $postID, $justConnect = false, $id = '')
    {

        if (!$justConnect) {
            $term = Terms::with('termTaxonomy')->whereHas('termTaxonomy', function ($query) {
                return $query->where('taxonomy', 'post_tag')->select('term_taxonomy_id');
            })->where(function ($query) use ($tag) {
                return $query->where('name', $tag['value'])->orWhere('slug', Str::slug($tag['value']));
            })->first();
            if (!empty($term))
                return TermRelationships::create(['post_id' => $postID, 'term_taxonomy_id' => $term->termTaxonomy->term_taxonomy_id]);
            else
                return self::insertTerm($tag, $postID);
        }
        return TermRelationships::create(['post_id' => $postID, 'term_taxonomy_id' => $id]);
    }


    static function insertTerm($tag, $postID)
    {
        $insert = Terms::create([
            'name'          => $tag['value'],
            'slug'          => Str::slug($tag['value']),
            'readable_date' => Helper::readableDateFormat(),
        ]);
        if ($insert) {
            $done = TermTaxonomy::create(['term_id' => $insert->term_id, 'taxonomy' => 'post_tag']);
            if ($done)
                return self::connectTerm($tag, $postID, true, $done->term_taxonomy_id);
        }
        return false;
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
    static function findPostForUpdate($id){
        $record = ModelPosts::with([
            'termRelationships' => function ($query) {
                $query->join('rix_term_taxonomy', 'rix_term_relationships.term_taxonomy_id', '=', 'rix_term_taxonomy.term_taxonomy_id')
                    ->join('rix_terms', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
                    ->select('post_id','rix_terms.term_id','rix_terms.name','rix_term_taxonomy.taxonomy');
            }])->where('post_id',$id)->first();
        if(!empty($record)){
            $featuredImage = Gallery::where('image_id',$record->featured_image)->first();
            if(!empty($featuredImage))
                $record->selected_featured_image = $featuredImage;
            return $record;
        }
        return false;

    }
}
