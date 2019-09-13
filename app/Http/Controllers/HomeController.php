<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function get_home()
    {
        return view('index');
    }

    public function get_contact()
    {
        return view('contact');
    }
    public function get_about()
    {
        return view('about');
    }
    public function get_gallery()
    {
        return view('gallery');
    }
    public function get_references()
    {
        return view('references');
    }
    public function get_discovery()
    {
        return view('discovery');
    }
}
