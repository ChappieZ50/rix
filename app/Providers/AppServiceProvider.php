<?php

namespace App\Providers;

use App\Classes\Settings;
use App\Models\Pages;
use App\Models\Posts;
use App\Models\Terms\Terms;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Cog\RobotsTxt\Providers\RobotsTxtServiceProvider::class);
            $this->app->register(\Intervention\Image\ImageServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        setLocale(LC_TIME, 'tr_TR');
        view()->composer('*', 'App\Http\ViewComposers\MessagesComposer');
        view()->composer('*', 'App\Http\ViewComposers\CommentsComposer');

        $setting = Settings::getSetting('security', 'security')->first();
        $setting = isset($setting->security) ? json_decode($setting->security) : $setting;
        $siteKey = isset($setting->recaptcha_site_key) ? $setting->recaptcha_site_key : false;
        $secretKey = isset($setting->recaptcha_secret_key) ? $setting->recaptcha_secret_key : false;
        $language = isset($setting->recaptcha_language) ? $setting->recaptcha_language : 'tr';
        \Config::set('recaptcha.site_key', $siteKey);
        \Config::set('recaptcha.secret_key', $secretKey);
        \Config::set('recaptcha.language', $language);
    }
}
