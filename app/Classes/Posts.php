<?php

namespace App\Classes;

use App\Models\Terms\Terms;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class Posts
{
    /*
     * For Categories And Tags Controller
     */
    static function getRecords($options = [], $render = false, $taxonomy = '', $blade = '')
    {
        $defaults = [
            'selectTerms'        => ['*'],
            'selectTermTaxonomy' => ['*'],
            'taxonomy'           => '',
            'paginate'           => 20,
            'termTaxonomyOrder'  => 'term_taxonomy_id',
            'termsOrder'         => 'created_at',
            'order_type'         => 'desc',
        ];
        $options = array_merge($defaults, $options);
        $data = Terms::with('termTaxonomy')
            ->whereHas('termTaxonomy', function ($query) use ($options) {
                $query->where('taxonomy', $options['taxonomy'])
                    ->select($options['selectTermTaxonomy'])
                    ->orderBy($options['termTaxonomyOrder'], $options['order_type']);
            })->select($options['selectTerms'])
            ->orderBy($options['termsOrder'], $options['order_type']);

        $data = $options['taxonomy'] === 'post_tag' ? $data->paginate($options['paginate']) : $data;

        return $render
            ? Helper::response(true, '', ['custom' => Helper::render($data, $taxonomy, $blade)])
            : $data;
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
            ->where('slug',$slug)->count();
        return DB::table('rix_terms')->count() > 0 && $term > 0 ? 0 : 1;
    }

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

    /*
     * Only for categories
     */
    static function parentCategories($term_id, $main = '', $loop = true, $taxonomy = 'category')
    {
        static $parentCategories = [];
        $record =  Terms::with('termTaxonomy')
            ->whereHas('termTaxonomy',function ($query) use ($taxonomy,$term_id){
                $query->where([
                    'taxonomy' => $taxonomy,
                    'parent' => $term_id
                ])->select(['count','parent']);
            })->select(['term_id', 'name', 'slug', 'readable_date'])->get()->toArray();
        if (!empty($record)) {
            $parentCategories[] = $record;
            if ($loop === true) {
                foreach ($record as $item) {
                    return self::parentCategories($item->term_id, $main);
                }
            } else {
                return ['main' => $main, 'records' => array_reduce($parentCategories, 'array_merge', [])];
            }
        } else {
            return ['main' => $main, 'records' => array_reduce($parentCategories, 'array_merge', [])];
        }
    }

    /*
     * Only for categories
     */
    static function getRendered()
    {
        $records = Posts::getRecords(['taxonomy' => 'category']);
        $tableItem = Posts::renderCategories($records->paginate(20), 'tableItems', 'rix.layouts.components.posts.categories.table');
        $parentItem = Posts::renderCategories($records->get(), 'parentItems', 'rix.layouts.components.posts.categories.parents');
        return ['table' => $tableItem, 'parents' => $parentItem];
    }
}
