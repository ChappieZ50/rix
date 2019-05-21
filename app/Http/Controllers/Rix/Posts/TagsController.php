<?php

namespace App\Http\Controllers\Rix\Posts;

use App\Models\Terms\TermRelationships;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Classes\Posts;
use App\Models\Terms\TermTaxonomy;
use App\Models\Terms\Terms;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    protected $selectTerms = ['term_id', 'name', 'slug', 'readable_date'];

    public function get_tags()
    {
        $tags = Posts::getRecords([
            'taxonomy'    => 'post_tag',
            'selectTerms' => $this->selectTerms,
            'paginate'    => 10
        ]);
        return view('rix.posts.tags', compact('tags'));
    }

    public function new_tag(Request $request)
    {
        $validate = ['name' => 'required|max:255', 'slug' => 'required|max:255'];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $name = $request->input('name');
            $slug = Str::slug($request->input('slug'));
            if (Posts::findExistRecord('post_tag', $name, $slug)) {
                $done = Terms::create([
                    'name'          => $name,
                    'slug'          => $slug,
                    'readable_date' => Helper::readableDateFormat()
                ])->termTaxonomy()->create(['taxonomy' => 'post_tag']);
                if ($done) {
                    return Posts::getRecords(
                        ['taxonomy' => 'post_tag', 'selectTerms' => $this->selectTerms],
                        true, 'tags',
                        'rix.layouts.components.posts.tags.table');

                }
                return Helper::response(false, 'Bir hata meydana geldi');
            }
            return Helper::response(false, 'Etiket daha önceden eklenmiş');
        }
        return Helper::response(false, '', ['errors' => $validator->errors()]);
    }

    public function delete_tags(Request $request)
    {
        if ($request->ajax() && $request->input('ids')) {
            $ids = $request->input('ids');
            $ids = !is_array($ids) ? [$ids] : $ids;
            TermRelationships::whereIn('term_taxonomy_id', $ids)->delete();
            if (TermTaxonomy::whereIn('term_id', $ids)->delete() && Terms::destroy($ids)) {
                return Posts::getRecords(
                    ['taxonomy' => 'post_tag', 'selectTerms' => $this->selectTerms],
                    true, 'tags',
                    'rix.layouts.components.posts.tags.table');
            }
            return Helper::response(false, 'Silinemedi');
        }
    }
}
