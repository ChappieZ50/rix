<?php

namespace App\Http\Controllers\Rix;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class LoginController extends Controller
{

    public function get_login()
    {
        if(\Auth::check())
            return redirect()->route('rix_home');
        return view('rix.login');
    }

    public function action_login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return redirect()->route('rix_login')->withErrors($validator->errors());
        } else {
            $userData = [
                'email'    => $request->input('email'),
                'password' => $request->input('password'),
            ];
            if (\Auth::attempt($userData, $request->input('remember') === 'on' ? true : false))
                return redirect()->route('rix_home');
            else
                return redirect()->route('rix_login')->withErrors([ 'Giriş işlemi başarısız' ]);
        }
    }
}
