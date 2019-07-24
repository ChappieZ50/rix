<?php

namespace App\Providers;

use App\Classes\Settings;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class RixServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $setting = \Cache::tags('SETTINGS')->rememberForever('SETTINGS.SECURITY', function () {
            $setting = Settings::getSetting('security', 'security')->first();
            return isset($setting->security) ? json_decode($setting->security) : $setting;
        });
        $siteKey = isset($setting->recaptcha_site_key) ? $setting->recaptcha_site_key : false;
        $secretKey = isset($setting->recaptcha_secret_key) ? $setting->recaptcha_secret_key : false;
        $language = isset($setting->recaptcha_language) ? $setting->recaptcha_language : 'tr';
        \Config::set('recaptcha.site_key', $siteKey);
        \Config::set('recaptcha.secret_key', $secretKey);
        \Config::set('recaptcha.language', $language);
    }
}
