<?php

namespace App\Http\Controllers\Rix;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    private $settings = [
        'cache'           => [ 'view' => 'rix.settings.cache', 'route' => 'rix_settings_cache' ],
        'email'           => [ 'view' => 'rix.settings.email', 'route' => 'rix_settings_email' ],
        'general'         => [ 'view' => 'rix.settings.general', 'route' => 'rix_settings_general' ],
        'security'        => [ 'view' => 'rix.settings.security', 'route' => 'rix_settings_security' ],
        'seo'             => [ 'view' => 'rix.settings.seo', 'route' => 'rix_settings_seo' ],
        'synchronization' => [ 'view' => 'rix.settings.synchronization', 'route' => 'rix_settings_synchronization' ]
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
        foreach ($this->settings as $setting) {
            if ($request->routeIs($setting->route))
                return view($setting->view)->with([

                ]);
        }
    }
}
