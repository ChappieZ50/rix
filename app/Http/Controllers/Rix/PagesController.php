<?php

namespace App\Http\Controllers\Rix;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function get_pages()
    {
        return view('rix.pages.pages');
    }

    public function get_page($id = '')
    {
        return view('rix.pages.page');
    }

    public function action_pages(Request $request)
    {

    }

    public function action_page(Request $request)
    {
        return $request->all();
    }
}
