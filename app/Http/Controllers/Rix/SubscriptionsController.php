<?php

namespace App\Http\Controllers\Rix;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Subscriptions;

class SubscriptionsController extends Controller
{
    public function get_subscriptions(Request $request)
    {
        $subscriptions = Subscriptions::getSubscriptions();
        if ($request->get('search')) {
            $value = $request->get('search');
            $subscriptions->where(function ($query) use ($value) {
                return $query->where('email', 'like','%'.$value.'%')->orWhere('ip', 'like','%'.$value.'%');
            });
        }
        return view('rix.subscription')->with('subscriptions', $subscriptions->paginate(20));
    }

    public function action_subscriptions(Request $request)
    {
        if ($request->ajax())
            return Subscriptions::deleteSubscriptions($request->input('data'));
    }
}
