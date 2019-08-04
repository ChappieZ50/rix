<?php

namespace App\Http\ViewComposers;

use App\Classes\Messages;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class MessagesComposer
{
    public function compose(View $view)
    {

        if (!empty(auth()->user()) && auth()->user()->role  === 'admin') {
            $messages = \Cache::tags('COMPOSE')->remember('MESSAGES', Carbon::now()->addHour(), function () {
                return Messages::getMessages(['whereValue' => 'unread'])->take(5)->get();
            });
            return $view->with('composeMessages', $messages);
        }
    }
}