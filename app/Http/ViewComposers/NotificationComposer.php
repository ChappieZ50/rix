<?php

namespace App\Http\ViewComposers;

use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class NotificationComposer
{
    public function compose(View $view)
    {
        if (!empty(auth()->user()) && auth()->user()->role === 'admin') {
            $notifications = \Cache::tags('COMPOSE')->remember('NOTIFICATIONS', Carbon::now()->addHour(), function () {
                return Notifications::all();
            });
            return $view->with('composeNotifications', $notifications);
        }
    }
}