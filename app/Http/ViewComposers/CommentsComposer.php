<?php

namespace App\Http\ViewComposers;

use App\Classes\Comments;
use Illuminate\Contracts\View\View;

class CommentsComposer
{
    public function compose(View $view)
    {
        $comments = Comments::getComments([ 'whereValue' => 'pending' ])->with([
            'user' => function ($query) {
                $query->select('user_id', 'avatar','username');
            } ])->take(8)->get();
        return $view->with('composeComments', $comments);
    }
}