<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Settings;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Subscriptions;

class SubscriptionsController extends Controller
{
    protected $types = [
        'ok',
        'no'
    ];
    public function get_subscriptions(Request $request)
    {
        $type = $request->get('type');
        if ($request->get('search')) {
            $subs = Subscriptions::search($request->get('search'),Helper::getPageType($type,$this->types));
            $records = $subs->paginate(20);
        } else {
            $records = Subscriptions::paginate(array_merge(Helper::findStatusOnParam($type, $this->types), ['whereColumn' => 'send']), 20, $request->get('type'), $request->get('page'));;
        }
        return view('rix.subscriptions.subscription')->with([
            'subscriptions' => $records,
            'typeData'      => Subscriptions::getTypeData(['type' => $type])
        ]);
    }

    public function get_send_email_subscriptions()
    {
        $setting = Settings::getSetting('email', 'email')->first();
        return view('rix.subscriptions.send_email', compact('setting'));
    }

    public function action_subscriptions(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('action') === 'delete')
                return Subscriptions::deleteSubscriptions($request->input('data'));
            else if ($request->input('action') === 'insert')
                return Subscriptions::insertSubscriber($request);
            else
                return Subscriptions::updateSubscriber($request);
        } else {
            return Subscriptions::insertSubscriber($request);
        }
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
            'title'   => $request->input('subject'),
            'message' => $request->input('message'),
            'name'    => $request->input('name'),
        ];
        $emails = \App\Models\Subscriptions::select('email', 'security')->where('send', 'ok')->get()->toArray();
        \App\Jobs\Subscriptions::dispatch($send, $emails)->onQueue('email');
        return redirect()->back()->with('success', 'İşleminiz kuyruğa alındı ve bittiğinde bildirim alacaksınız.');
    }
}
