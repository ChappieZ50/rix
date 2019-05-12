<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class Posts
{
    /*
     * For Categories And Tags Controller
     */
    private static $depth = 0;

    static function getRecords($options = [], $render = false, $taxonomy = '', $blade = '')
    {
        $defaults = [
            'select'       => [
                'rix_terms.term_id', 'rix_terms.name',
                'rix_terms.slug', 'rix_terms.readable_date',
                'rix_term_taxonomy.count', 'rix_term_taxonomy.parent'
            ],
            'taxonomy'     => '',
            'paginate'     => 20,
            'order_column' => 'rix_terms.created_at',
            'order_type'   => 'desc',
            'all'          => false
        ];
        $options = array_merge($defaults, $options);
        $data = DB::table('rix_terms')
            ->join('rix_term_taxonomy', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
            ->where('rix_term_taxonomy.taxonomy', $options['taxonomy'])
            ->select($options['select'])
            ->orderBy($options['order_column'], $options['order_type']);
        $data = $options['all'] ? $data->get()->toArray() : $data->paginate($options['paginate']);

        return $render ?
            Helper::response(true, '',
                ['custom' => Helper::render($data, $taxonomy, $blade)])
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

    static function findParentName($records, $taxonomy)
    {
        if (!empty($records)) {
            foreach ($records as $record) {
                $parent_name = DB::table('rix_terms')
                    ->join('rix_term_taxonomy', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
                    ->where([
                        'rix_term_taxonomy.taxonomy' => $taxonomy,
                        'rix_term_taxonomy.term_id'  => $record->parent
                    ])
                    ->select(['rix_terms.name', 'rix_terms.slug'])
                    ->first();
                $record->{'parent_name'} = isset($parent_name->name) ? $parent_name->name : null;
            }
        }
        return $records;
    }


    static function depthAdder($parent)
    {
        $taxonomy = 'category';
        $record = (array) DB::table('rix_terms')
            ->join('rix_term_taxonomy', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
            ->where('rix_term_taxonomy.taxonomy', $taxonomy)
            ->where('rix_term_taxonomy.term_id', $parent)
            ->select('rix_term_taxonomy.parent')
            ->get()->toArray();
        if (!empty($record)) {
            foreach($record as $item){
                self::$depth++;
                return self::depthAdder($item->parent);
            }
        } else {
            return self::$depth;
        }
    }
}
