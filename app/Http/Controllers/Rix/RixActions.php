<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Subscriptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RixActions extends Controller
{
    public function get_action(Request $request)
    {
        if ($request->has('action') && $request->has('token')) {
            $action = $request->get('action');
            $token = $request->get('token');
            return $this->action($action, $token);
        } else {
            return redirect('/');
        }
    }

    public function action($action, $token)
    {
        if ($action === 'unsubscribe') {
            $subscribe = Subscriptions::unSubscribe($token);
            return view('rix.actions.unsubscribe')->with('unsubscribe', $subscribe ? true : false);
        }

        return redirect('');
    }
}
