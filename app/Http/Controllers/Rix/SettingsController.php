<?php

namespace App\Http\Controllers\Rix;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function get_settings()
    {
        return view('rix.settings');
    }
}
