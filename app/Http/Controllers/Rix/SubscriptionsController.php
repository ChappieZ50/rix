<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Settings;
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
                return $query->where('email', 'like', '%' . $value . '%')->orWhere('ip', 'like', '%' . $value . '%');
            });
        }
        return view('rix.subscriptions.subscription')->with('subscriptions', $subscriptions->paginate(20));
    }

    public function get_send_email_subscriptions()
    {
        $setting = Settings::getSetting('email', 'email')->first();
        return view('rix.subscriptions.send_email',compact('setting'));
    }

    public function action_subscriptions(Request $request)
    {
        if ($request->ajax())
            return Subscriptions::deleteSubscriptions($request->input('data'));
    }

    public function action_send_email_subscriptions(Request $request)
    {
        return $request->all();
    }
}
