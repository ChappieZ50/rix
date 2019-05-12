<?php

namespace App\Classes;

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
            'select'       => ['*'],
            'taxonomy'     => '',
            'paginate'     => 20,
            'order_column' => 'rix_terms.created_at',
            'order_type'   => 'desc',
        ];
        $options = array_merge($defaults, $options);
        $data = DB::table('rix_terms')
            ->join('rix_term_taxonomy', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
            ->where('rix_term_taxonomy.taxonomy', $options['taxonomy'])
            ->select($options['select'])
            ->orderBy($options['order_column'], $options['order_type']);
        $data = $options['taxonomy'] === 'post_tag' ? $data->paginate($options['paginate']) : $data;

        return $render
            ? Helper::response(true, '', ['custom' => Helper::render($data, $taxonomy, $blade)])
            : $data;
    }

    static function findExistRecord($taxonomy, $name, $slug, $parent = 0)
    {
        $term = DB::table('rix_terms')
            ->join('rix_term_taxonomy', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
            ->where([
                'rix_term_taxonomy.taxonomy' => $taxonomy,
                'rix_term_taxonomy.parent'   => $parent,
                'rix_terms.name'             => $name
            ])
            ->orWhere('rix_term_taxonomy.taxonomy', $taxonomy)
            ->where([
                'rix_term_taxonomy.parent' => $parent,
                'rix_terms.slug'           => $slug
            ])
            ->count();

        return DB::table('rix_terms')->count() > 0 && $term > 0 ? 0 : 1;
    }

    /*
     * Only for categories
     */
    static function renderCategories($data, $variable, $blade)
    {
        $view = view($blade)->with([
            $variable => $data
        ])->render();
        return response()->json(['html' => $view, 'data' => $data]);
    }

    /*
     * Only for categories
     */
    static function parentCategories($term_id, $main = '', $taxonomy = 'category')
    {
        static $parentCategories =  [];
        $record = (array)DB::table('rix_terms')
            ->join('rix_term_taxonomy', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
            ->where([
                'rix_term_taxonomy.taxonomy' => $taxonomy,
                'rix_term_taxonomy.parent'  => $term_id,])
            ->select(['rix_terms.term_id', 'rix_terms.name', 'rix_terms.slug', 'rix_term_taxonomy.count', 'rix_terms.readable_date', 'rix_term_taxonomy.parent'])
            ->get()->toArray();
        if (!empty($record)) {
            $parentCategories[] = $record;
            foreach ($record as $item) {
                return self::parentCategories($item->term_id, $main);
            }
        } else {
            return ['main' => $main, 'records' => array_reduce($parentCategories,'array_merge',[])];
        }
    }
}
