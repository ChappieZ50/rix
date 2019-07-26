<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
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
        view()->composer('rix.*', 'App\Http\ViewComposers\MessagesComposer');
        view()->composer('rix.*', 'App\Http\ViewComposers\CommentsComposer');
        view()->composer('rix.*', 'App\Http\ViewComposers\NotificationComposer');
    }
}
