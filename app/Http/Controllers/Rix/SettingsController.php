<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private $settings = [
        'cache'    => [ 'view' => 'rix.settings.cache', 'route' => 'rix_settings_cache', 'default' => 'cache' ],
        'email'    => [ 'view' => 'rix.settings.email', 'route' => 'rix_settings_email', 'default' => 'email' ],
        'general'  => [ 'view' => 'rix.settings.general', 'route' => 'rix_settings_general', 'default' => 'general_settings' ],
        'security' => [ 'view' => 'rix.settings.security', 'route' => 'rix_settings_security', 'default' => 'security' ],
        'seo'      => [ 'view' => 'rix.settings.seo', 'route' => 'rix_settings_seo', 'default' => 'seo' ],
    ];

    public function __construct()
    {
        $this->settings = json_decode(json_encode($this->settings));
    }

    public function get_settings()
    {
        return view('rix.settings.settings');
    }

    public function get_setting(Request $request)
    {
        foreach ($this->settings as $key => $setting)
            if ($request->routeIs($setting->route)) {
                if ($request->isMethod('get')) {
                    return view($setting->view)->with('setting', Settings::getSetting($key, $request->get('setting') ? $request->get('setting') : $setting->default)->first());
                } elseif ($request->isMethod('post')) {
                    return $this->action_setting($request, $key);
                }
            }
        return abort(404);
    }

    public function action_setting($request, $page)
    {
        if ($request->has('refreshCache'))
            if (\Cache::flush())
                return redirect()->back()->with('success', 'Önbellek Başarıyla Sıfırlandı!');
            else
                return redirect()->back()->with('error', 'Bir Sorun Oluştu!');
        return Settings::createOrUpdate($request, $page);
    }
}
