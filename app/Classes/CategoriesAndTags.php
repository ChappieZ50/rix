<?php

namespace App\Classes;

use App\Models\Terms\Terms;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Str;
class CategoriesAndTags
{
    /*
     * For Both
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
     * For Categories
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
}
