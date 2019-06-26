<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Pages;
use App\Models\Gallery;
use App\Models\Pages as ModelPages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function get_pages(ModelPages $pages, Request $request)
    {
        if ($request->get('search'))
            $pages = $pages->where('title', 'like', '%' . $request->get('search') . '%');
        return view('rix.pages.pages')->with('pages', $pages->paginate(20));
    }

    public function get_page(ModelPages $pages, $id = '')
    {
        $view = view('rix.pages.page');
        if (!empty($id)) {
            $page = $pages->where('page_id', $id)->first();
            if (!empty($page)) {
                $featuredImage = Gallery::where('image_id', $page->featured_image)->first();
                if (!empty($featuredImage))
                    $page->selected_featured_image = $featuredImage;
                return $view->with('page', $page);
            }
            return abort(404);
        }
        return $view;
    }

    public function action_pages(Request $request)
    {
        if ($request->ajax())
            return Pages::actionPages($request);
    }

    public function action_page(Request $request)
    {
        if ($request->has('id'))
            return Pages::updatePage($request);
        else
            return Pages::createPage($request);
    }
}
