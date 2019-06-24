<?php

namespace App\Http\Controllers\Rix;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function get_profile()
    {
        $user = Users::where('user_id',\Auth::user()->user_id)->first();
        return view('rix.profile',compact('user'));
    }

    public function update_profile(Request $request)
    {
        $request->merge(['role' => \Auth::user()->role,'id' => \Auth::user()->user_id]);
        return \App\Classes\Users::updateUser($request);
    }
}
