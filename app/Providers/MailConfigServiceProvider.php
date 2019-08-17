<?php

namespace App\Providers;

use App\Classes\Settings;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
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
        if (\Schema::hasTable('rix_settings')) {
            $setting = \Cache::tags('SETTINGS')->rememberForever('SETTINGS.EMAIL', function () {
                $setting = Settings::getSetting('email', 'email')->first();
                return isset($setting->email) ? json_decode($setting->email) : $setting;
            });
            if (!empty($setting)) {
                $configs = [
                    'driver' => 'smtp',
                    'host' => $setting->email_host,
                    'port' => $setting->email_port,
                    'from' => ['address' => $setting->email, 'name' => config('app.name')],
                    'encryption' => $setting->security_type,
                    'username' => !empty($setting->username) ? $setting->username :  $setting->email,
                    'password' => $setting->email_password,
                ];
                \Config::set('mail', $configs);
            }
        }
    }
}
