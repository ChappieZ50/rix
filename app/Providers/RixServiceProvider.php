<?php

namespace App\Providers;

use App\Classes\Settings;
use App\Models\Notifications;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
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
        if (\Schema::hasTable('rix_settings')) {
            // For security settings
            $securitySetting = \Cache::tags('SETTINGS')->rememberForever('SETTINGS.SECURITY', function () {
                $setting = Settings::getSetting('security', 'security')->first();
                return isset($setting->security) ? json_decode($setting->security) : $setting;
            });
            $siteKey = isset($securitySetting->recaptcha_site_key) ? $securitySetting->recaptcha_site_key : false;
            $secretKey = isset($securitySetting->recaptcha_secret_key) ? $securitySetting->recaptcha_secret_key : false;
            $language = isset($securitySetting->recaptcha_language) ? $securitySetting->recaptcha_language : 'tr';
            \Config::set('recaptcha.site_key', $siteKey);
            \Config::set('recaptcha.secret_key', $secretKey);
            \Config::set('recaptcha.language', $language);
        }
        \Queue::after(function (JobProcessed $event) {
            $queues = $event->job->getQueue();
            $queues = is_array($queues) ? $queues : explode(',', $queues);
            foreach ($queues as $queue) {
                if ($queue === 'email') {
                    Notifications::create([
                        'name'    => $queue,
                        'title'   => 'E-Posta',
                        'content' => 'E-Posta gönderme işlemi başarıyla tamamlandı.',
                        'status'  => 'success',
                    ]);
                }
            }
        });
        \Queue::failing(function (JobFailed $failed) {
            $queues = $failed->job->getQueue();
            $queues = is_array($queues) ? $queues : explode(',', $queues);
            foreach ($queues as $queue) {
                if ($queue === 'email') {
                    Notifications::create([
                        'name'    => $queue,
                        'title'   => 'E-Posta',
                        'content' => 'E-Posta gönderme işlemi başarısız oldu.',
                        'status'  => 'failed',
                    ]);
                }
            }
        });
    }
}
