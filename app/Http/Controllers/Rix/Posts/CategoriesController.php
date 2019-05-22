<?php

namespace App\Http\Controllers\Rix\Posts;

use App\Models\Terms\TermRelationships;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Classes\Posts;
use App\Models\Terms\Terms;
use App\Models\Terms\TermTaxonomy;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function get_categories(Request $request)
    {
        if ($request->ajax()) {
            $action = $request->input('action');
            if ($action == 'search') {
                if ($request->input('value') && !empty($request->input('value')))
                    return $this->search($request->input('value'));
            } elseif ($action == 'getParents' && !empty($request->input('term_id'))) {
                $parents = Posts::parentCategories($request->input('term_id'), $request->input('main'), false);
                return Posts::renderCategories($parents, 'parentCategories', 'rix.layouts.components.posts.categories.parent-categories-modal');
            } elseif ($action == 'getTable') {
                $records = Posts::getRecords(['taxonomy' => 'category', 'doPaginate' => true]);
                return Posts::renderCategories($records, 'tableItems', 'rix.layouts.components.posts.categories.table');
            }
        }
        $categories = Posts::getRecords(['taxonomy' => 'category']);
        $view = [
            'tableItems'  => $categories->paginate(20),
            'parentItems' => $categories->get(),
            'editItem'    => '',
        ];
        if ($request->get('action') == 'edit' && $request->get('id')) {
            $editCategory = $categories->where('term_id', $request->input('id'))->first();
            if (!empty($editCategory))
                $view['editItem'] = $editCategory;
            else
                return redirect()->route('rix_categories');
        }
        return view('rix.posts.categories')->with($view);
    }

    public function new_category(Request $request)
    {
        $validate = ['name' => 'required|max:255', 'slug' => 'required|max:255', 'parent' => 'required'];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $name = $request->input('name');
            $slug = Str::slug($request->input('slug'));
            $parent = $request->input('parent');
            if (Posts::findExistRecord('category', $name, $slug, $parent)) {
                $done = Terms::create([
                    'name'          => $name,
                    'slug'          => $slug,
                    'readable_date' => Helper::readableDateFormat()
                ])->termTaxonomy()->create(['taxonomy' => 'category', 'parent' => $parent,]);
                if ($done)
                    return Posts::getRendered();
            } else {
                return Helper::response(false, 'Kategori daha önceden eklenmiş');
            }
        }
        return Helper::response(false, '', ['errors' => $validator->errors()]);
    }

    public function delete_category(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('confirm'))
                return $this->confirmDelete($request->input('data'));
            $data = [];
            $ids = $request->input('ids');
            $ids = is_array($ids) ? $ids : [$ids];
            foreach ($ids as $id) {
                $record = Posts::parentCategories($id);
                if (empty($record['records'])) {
                    $data['noParent'][] = $id;
                } else {
                    $data['yesParent']['records'] = $record['records'];
                    $data['yesParent']['id'][] = $id;
                }
            }
            if (isset($data['yesParent']) && !empty($data['yesParent']))
                return ['confirm' => true, 'data' => $data];
            else
                return $this->deleteAll($data['noParent']);
        }
    }

    private function confirmDelete($data)
    {
        if (isset($data['noParent']))
            $this->deleteAll($data['noParent']);
        $ids = $data['yesParent']['id'];
        $records = $data['yesParent']['records'];
        foreach ($records as $record)
            TermTaxonomy::where('parent', $record['term_taxonomy']['parent'])->update(['parent' => 0]);
        return $this->deleteAll($ids);
    }

    private function deleteAll($ids)
    {
        TermRelationships::whereIn('term_taxonomy_id', $ids)->delete();
        if (TermTaxonomy::whereIn('term_id', $ids)->delete() && Terms::destroy($ids))
            return Posts::getRendered();
        return Helper::response(false, 'Silinemedi');
    }

    public function update_category(Request $request)
    {
        $validate = ['name' => 'required|max:255', 'slug' => 'required|max:255', 'parent' => 'required', 'id' => 'required|integer'];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {

            $name = $request->input('name');
            $slug = Str::slug($request->input('slug'));
            $parent = $request->input('parent');
            $id = $request->input('id');
            if (Posts::findExistRecord('category', $name, $slug, $parent)) {
                $termParent = TermTaxonomy::where([
                    'parent' => $id,
                ])->select(['parent', 'term_id'])->get();
                if (!empty($termParent)) {
                    foreach ($termParent as $term) {
                        if ($term->term_id == $parent)
                            return Helper::response(false, 'Seçtiğiniz alt kategori zaten kendisinin bir alt kategorisi');
                    }
                }
                $update = \DB::table('rix_terms')
                    ->join('rix_term_taxonomy', 'rix_term_taxonomy.term_id', '=', 'rix_terms.term_id')
                    ->where('rix_terms.term_id', $id)
                    ->update([
                        'name'   => $name,
                        'slug'   => $slug,
                        'parent' => $parent
                    ]);
                if ($update)
                    return Posts::getRendered();

            } else {
                return Helper::response(false, 'Değişiklik yapmadınız');
            }
        }
        return Helper::response(false, '', ['errors' => $validator->errors()]);
    }

    private function search($value)
    {
        $data = Terms::whereHas('termTaxonomy', function ($query) {
            return $query->where('taxonomy', 'category');
        })->where(function ($query) use ($value) {
            return $query->where('name', 'like', '%' . $value . '%')->orWhere('slug', 'like', '%' . Str::slug($value) . '%');
        })->orderBy('created_at', 'desc')->paginate(20);
        return Posts::renderCategories($data, 'tableItems', 'rix.layouts.components.posts.categories.table');
    }
}
