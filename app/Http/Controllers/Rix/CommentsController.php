<?php

namespace App\Http\Controllers\Rix;

use App\Models\Activity;
use App\Models\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class CommentsController extends Controller
{
    public function get_comments(){
        $a = Posts::first();
        dd($a->with('activity')->get()->toArray());
        die();
        return view('rix.comments');
    }
}
