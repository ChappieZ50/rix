<?php

namespace App\Http\ViewComposers;

use App\Classes\Messages;
use Illuminate\Contracts\View\View;

class MessagesComposer
{
    public function compose(View $view)
    {
        $messages = Messages::getMessages([ 'whereValue' => 'unread' ])->take(5)->get();
        return $view->with('composeMessages', $messages);
    }
}