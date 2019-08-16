<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Settings;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    private $googleVerifyLink = 'https://www.google.com/recaptcha/api/siteverify';

    public function get_login()
    {
        if (\Auth::check())
            return redirect()->route('rix_home');
        return view('rix.login')->with(
            'setting', Settings::getSetting('security', 'security')->first()
        );
    }

    public function action_login(Request $request)
    {
        $existsRecaptcha = Helper::recaptchaIsHave();
        $useInPanel = Helper::recaptchaRequirements('status_recaptcha_panel',1);
        $validate = [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ];
        if ($existsRecaptcha && $useInPanel)
            $validate = array_merge($validate, [ 'g-recaptcha-response' => 'required' ]);

        $validator = \Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return redirect()->route('rix.login')->withErrors($validator->errors());
        } else {
            if ($existsRecaptcha && $useInPanel) {
                $response = $this->sendRecaptchaRequest($request);
                if ($response->success !== true)
                    return redirect()->route('rix.login')->withErrors([ 'Giriş işlemi başarısız' ]);
            }
            $userData = [
                'email'    => $request->input('email'),
                'password' => $request->input('password'),
            ];
            if (\Auth::attempt($userData, $request->input('remember') === 'on' ? true : false))
                return redirect()->route('rix.home');
            else
                return redirect()->route('rix.login')->withErrors([ 'Giriş işlemi başarısız' ]);
        }
    }

    private function sendRecaptchaRequest($request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $this->googleVerifyLink,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => [
                'secret'   => config('recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip()
            ]
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}
