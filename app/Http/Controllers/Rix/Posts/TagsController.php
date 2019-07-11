<?php

namespace App\Http\Controllers\Rix\Posts;

use App\Classes\Sitemap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Classes\CategoriesAndTags as Tags;
use App\Models\Terms\Terms;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    protected $selectTerms = [ 'term_id', 'name', 'slug', 'readable_date' ];

    public function get_tags(Request $request)
    {
        if ($request->ajax()) {
            $action = $request->input('action');
            if ($action == 'search') {
                if ($request->input('value') && !empty($request->input('value')))
                    return Tags::search($request->input('value'), 'post_tag', 'tags', 'rix.layouts.components.posts.tags.table');
            } elseif ($action == 'getTable') {
                $records = Tags::getRecords([ 'taxonomy' => 'post_tag', 'doPaginate' => true ]);
                return Tags::renderCategories($records, 'tags', 'rix.layouts.components.posts.tags.table');
            }
        }
        if ($request->get('search'))
            $tags = Tags::search($request->get('search'), 'post_tag');
        else
            $tags = Tags::getRecords([ 'taxonomy' => 'post_tag', 'selectTerms' => $this->selectTerms, ]);

        $view = [ 'tags' => $tags->paginate(20), 'editTag' => '', ];
        if ($request->get('action') == 'edit' && $request->get('id')) {
            $editTag = $tags->where('term_id', $request->input('id'))->first();
            if (!empty($editTag))
                $view['editTag'] = $editTag;
            else
                return redirect()->route('rix_tags');
        }
        return view('rix.posts.tags')->with($view);
    }

    public function new_tag(Request $request)
    {
        $validate = [ 'name' => 'required|max:255', 'slug' => 'required|max:255' ];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $name = $request->input('name');
            $slug = Str::slug($request->input('slug'));
            if (Tags::findExistRecord('post_tag', $name, $slug)) {
                $done = Terms::create([
                    'name'          => $name,
                    'slug'          => $slug,
                    'readable_date' => Helper::readableDateFormat()
                ])->termTaxonomy()->create([ 'taxonomy' => 'post_tag' ]);
                Sitemap::refresh();
                if ($done) {
                    $records = Tags::getRecords([ 'taxonomy' => 'post_tag', 'selectTerms' => $this->selectTerms, 'doPaginate' => true ]);
                    return Helper::render($records, 'tags', 'rix.layouts.components.posts.tags.table');
                }
                return Helper::response(false, 'Bir hata meydana geldi');
            }
            return Helper::response(false, 'Etiket daha önceden eklenmiş');
        }
        return Helper::response(false, '', [ 'errors' => $validator->errors() ]);
    }

    public function delete_tags(Request $request)
    {
        if ($request->ajax() && $request->input('ids')) {
            $ids = $request->input('ids');
            $ids = !is_array($ids) ? [ $ids ] : $ids;
            if (Terms::destroy($ids)) {
                $records = Tags::getRecords([ 'taxonomy' => 'post_tag', 'selectTerms' => $this->selectTerms, 'doPaginate' => true ]);
                return Helper::render($records, 'tags', 'rix.layouts.components.posts.tags.table');
            }
            return Helper::response(false, 'Silinemedi');
        }
    }

    public function update_tag(Request $request)
    {
        $validate = [ 'name' => 'required|max:255', 'slug' => 'required|max:255', 'id' => 'required|integer' ];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $name = $request->input('name');
            $slug = Str::slug($request->input('slug'));
            $id = $request->input('id');
            if (Tags::findExistRecord('post_tag', $name, $slug)) {
                $update = Terms::where('term_id', $id)->update($request->only('name', 'slug'));
                if ($update) {
                    $records = Tags::getRecords([ 'taxonomy' => 'post_tag', 'selectTerms' => $this->selectTerms, 'doPaginate' => true ]);
                    Sitemap::refresh();
                    return Helper::render($records, 'tags', 'rix.layouts.components.posts.tags.table');
                }

            } else {
                return Helper::response(false, 'Etiket Zaten Mevcut');
            }
        }
        return Helper::response(false, '', [ 'errors' => $validator->errors() ]);
    }
}
