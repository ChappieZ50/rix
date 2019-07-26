<?php

namespace App\Http\ViewComposers;

use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class NotificationComposer
{
    public function compose(View $view)
    {
        $notifications = \Cache::tags('COMPOSE')->remember('NOTIFICATIONS',Carbon::now()->addHour(),function(){
            return Notifications::all();
        });
        return $view->with('composeNotifications', $notifications);
    }
}