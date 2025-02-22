<?php

namespace App\Http\Controllers\Rix\Posts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Classes\CategoriesAndTags as Categories;
use App\Models\Terms\Terms;
use App\Models\Terms\TermTaxonomy;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function get_categories(Request $request)
    {
        if ($request->ajax()) {
            $action = $request['action'];
            if ($action == 'getParents' && !empty($request->input('term_id'))) {
                $parents = Categories::parentCategories($request->input('term_id'), $request->input('main'), false);
                return Categories::renderCategories($parents, 'parentCategories', 'rix.layouts.components.posts.categories.parent-categories-modal');
            } elseif ($action == 'getTable') {
                $records = Categories::getRecords([ 'taxonomy' => 'category', 'doPaginate' => true ]);
                return Categories::renderCategories($records, 'tableItems', 'rix.layouts.components.posts.categories.table');
            }
        }
        if ($request->get('search'))
            $categories = Categories::search($request->get('search'), 'category');
        else
            $categories = Categories::getRecords([ 'taxonomy' => 'category' ]);
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
                return redirect()->route('rix.categories');
        }
        return view('rix.posts.categories')->with($view);
    }

    public function new_category(Request $request)
    {
        $validate = [ 'name' => 'required|max:255', 'slug' => 'required|max:255', 'parent' => 'required' ];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $name = $request->input('name');
            $slug = Str::slug($request->input('slug'));
            $parent = $request->input('parent');
            if (Categories::findExistRecord('category', $name, $slug, $parent)) {
                $done = Terms::create([
                    'name'          => $name,
                    'slug'          => $slug,
                    'readable_date' => Helper::readableDateFormat()
                ])->termTaxonomy()->create([ 'taxonomy' => 'category', 'parent' => $parent, ]);
                if ($done)
                    return Categories::getRenderedCategories();
            } else {
                return Helper::response(false, 'Kategori daha önceden eklenmiş');
            }
        }
        return Helper::response(false, '', [ 'errors' => $validator->errors() ]);
    }

    public function delete_category(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('confirm'))
                return $this->confirmDelete($request->input('data'));
            $data = [];
            $ids = $request->input('ids');
            $ids = is_array($ids) ? $ids : [ $ids ];
            foreach ($ids as $id) {
                $record = Categories::parentCategories($id);
                if (empty($record['records'])) {
                    $data['noParent'][] = $id;
                } else {
                    $data['yesParent']['records'] = $record['records'];
                    $data['yesParent']['id'][] = $id;
                }
            }
            if (isset($data['yesParent']) && !empty($data['yesParent']))
                return [ 'confirm' => true, 'data' => $data ];
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
            TermTaxonomy::where('parent', $record['term_taxonomy']['parent'])->update([ 'parent' => 0 ]);
        return $this->deleteAll($ids);
    }

    private function deleteAll($ids)
    {
        if (Terms::destroy($ids))
            return Categories::getRenderedCategories();
        return Helper::response(false, 'Silinemedi');
    }

    public function update_category(Request $request)
    {
        $validate = [ 'name' => 'required|max:255', 'slug' => 'required|max:255', 'parent' => 'required', 'id' => 'required|integer' ];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {

            $name = $request->input('name');
            $slug = Str::slug($request->input('slug'));
            $parent = $request->input('parent');
            $id = $request->input('id');
            if (Categories::findExistRecord('category', $name, $slug, $parent)) {
                $termParent = TermTaxonomy::where([
                    'parent' => $id,
                ])->select([ 'parent', 'term_id' ])->get();
                if (!empty($termParent)) {
                    foreach ($termParent as $term) {
                        if ($term->term_id == $parent)
                            return Helper::response(false, 'Seçtiğiniz alt kategori zaten kendisinin bir alt kategorisi');
                    }
                }
                $term = Terms::find($id);
                $updateTermTaxonomy = $term->termTaxonomy()->update([ 'parent' => $parent ]);
                $updateTerm = $term->update([
                    'name' => $name,
                    'slug' => $slug,
                ]);
                if ($updateTermTaxonomy || $updateTerm)
                    return Categories::getRenderedCategories();

            } else {
                return Helper::response(false, 'Kategori Zaten Mevcut');
            }
        }
        return Helper::response(false, '', [ 'errors' => $validator->errors() ]);
    }


}
