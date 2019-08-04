<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Rix;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RixController extends Controller
{

    public function get_rix()
    {
        $records = Rix::records();
        return view('rix.index',compact('records'));
    }
}
