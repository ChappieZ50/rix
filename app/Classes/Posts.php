<?php

namespace App\Classes;

use App\Models\Terms\Terms;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Models\Posts as ModelPosts;
class Posts
{
    /*
     * Only for categories
     */
    static function renderCategories($data, $variable, $blade)
    {
        $view = view($blade)->with([
            $variable  => $data,
            'editItem' => ''
        ])->render();
        return response()->json(['html' => $view, 'data' => $data]);
    }

    static function parentCategories($term_id, $main = '', $toArray = true)
    {
        $record = Terms::with('termTaxonomy')
            ->whereHas('termTaxonomy', function ($query) use ($term_id) {
                $query->where([
                    'taxonomy' => 'category',
                    'parent'   => $term_id
                ])->select(['count', 'parent']);
            })->select(['term_id', 'name', 'slug', 'readable_date'])->get();
        $record = $toArray ? $record->toArray() : $record;
        $data = ['main' => $main, 'records' => $record];
        return $toArray ? $data : (object)$data;
    }

    static function getRenderedCategories()
    {
        $records = self::getRecords(['taxonomy' => 'category']);
        $tableItem = self::renderCategories($records->paginate(20), 'tableItems', 'rix.layouts.components.posts.categories.table');
        $parentItem = self::renderCategories($records->get(), 'parentItems', 'rix.layouts.components.posts.categories.parents');
        return ['table' => $tableItem, 'parents' => $parentItem];
    }

    /*
     * Only for categories and tags
     */
    static function search($value, $taxonomy, $variable, $blade)
    {
        $data = Terms::whereHas('termTaxonomy', function ($query) use ($taxonomy) {
            return $query->where('taxonomy', $taxonomy);
        })->where(function ($query) use ($value) {
            return $query->where('name', 'like', '%' . $value . '%')->orWhere('slug', 'like', '%' . Str::slug($value) . '%');
        })->orderBy('created_at', 'desc')->paginate(20);
        return self::renderCategories($data, $variable, $blade);
    }

    static function findExistRecord($taxonomy, $name, $slug, $parent = 0)
    {
        $term = Terms::with('termTaxonomy')
            ->whereHas('termTaxonomy', function ($query) use ($taxonomy, $parent) {
                $query->where([
                    'taxonomy' => $taxonomy,
                    'parent'   => $parent
                ]);
            })
            ->where('name', $name)
            ->orWhereHas('termTaxonomy', function ($query) use ($taxonomy, $parent) {
                $query->where([
                    'taxonomy' => $taxonomy,
                    'parent'   => $parent,
                ]);
            })
            ->where('slug', $slug)->count();
        return DB::table('rix_terms')->count() > 0 && $term > 0 ? 0 : 1;
    }

    static function getRecords($options = [])
    {
        $defaults = [
            'selectTerms'        => ['*'],
            'selectTermTaxonomy' => ['*'],
            'taxonomy'           => '',
            'paginate'           => 20,
            'doPaginate'         => false,
            'termTaxonomyOrder'  => 'term_taxonomy_id',
            'termsOrder'         => 'created_at',
            'order_type'         => 'desc',
            'get'                => false,
            'response'           => false,
        ];
        $options = array_merge($defaults, $options);

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
        return $options['response'] ? Helper::response(true) : $data;
    }

    /*
     * Only for posts
     */

    static function getPosts($options = [])
    {
        $defaults = [
            'wherePostColumn' => '',
            'wherePostValue'  => '',
            'orderByColumn'   => 'created_at',
            'orderByType'     => 'desc',
            'whereInPostColumn' => '',
            'whereInPostValue' => '',
        ];
        $options = array_merge($defaults, $options);
        $records = ModelPosts::with('termRelationships.termTaxonomy.terms')->orderBy($options['orderByColumn'], $options['orderByType']);

        // Other Way
        /*$records = \App\Models\ModelPosts::with([
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

    static function getRenderedPosts($type)
    {
        $records = $type == 'open' || empty($type) ? self::getPosts(['whereInPostColumn' => 'status','whereInPostValue' => ['closed','open']]) : self::getPosts(['wherePostColumn' => 'status', 'wherePostValue' => $type]);
        $viewData = self::getViewData();
        $viewData['posts'] = $records->paginate(20);
        $posts = self::renderPosts($viewData, 'rix.layouts.components.posts.posts.posts-table');
        return $posts;
    }

    static function getViewData()
    {
        return [
            'all' => self::getPosts(['whereInPostColumn' => 'status','whereInPostValue' => ['closed','open']])->count(),
            'open'   => self::getPostCount('status', 'open'),
            'closed' => self::getPostCount('status', 'closed'),
            'trash'  => self::getPostCount('status', 'trash'),
        ];
    }

    static function getRenderedTablePagesBar(){
        return self::renderPosts(self::getViewData(),'rix.layouts.components.posts.posts.table-pages-bar');
    }
}
