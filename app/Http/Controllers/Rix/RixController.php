<?php

namespace App\Http\Controllers\Rix;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RixController extends Controller
{
    public function get_rix(){
        return view('rix.index');
    }
}
