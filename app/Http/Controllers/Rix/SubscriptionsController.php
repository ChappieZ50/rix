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
        if ($request->get('search')) {
            $subs = Subscriptions::search($request->get('search'));
            $records = $subs->paginate(20);
        } else {
            $records = Subscriptions::paginate($request, 20);
        }

        return view('rix.subscriptions.subscription')->with('subscriptions', $records);
    }

    public function get_send_email_subscriptions()
    {
        $setting = Settings::getSetting('email', 'email')->first();
        return view('rix.subscriptions.send_email', compact('setting'));
    }

    public function action_subscriptions(Request $request)
    {
        if ($request->ajax())
            return Subscriptions::deleteSubscriptions($request->input('data'));
    }

    public function action_send_email_subscriptions(Request $request)
    {
        $validate = [
            'email'   => 'email|required',
            'name'    => 'required',
            'message' => 'required',
            'subject' => 'required',
        ];
        $validator = \Validator::make($request->all(), $validate);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator);

        $send = (object)[
            'title'           => $request->input('subject'),
            'message'         => $request->input('message'),
            'name'            => $request->input('name'),
            'unsubscribe_url' => ''
        ];
        $emails = \App\Models\Subscriptions::select('email')->get()->toArray();
        \App\Jobs\Subscriptions::dispatch($send, $emails)->onQueue('email');
        return redirect()->back()->with('success', 'İşleminiz kuyruğa alındı ve bittiğinde bildirim alacaksınız.');
    }
}
