<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Messages;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    protected $types = [ 'read', 'unread', 'trash' ];

    public function get_messages(Request $request)
    {


        $type = $request->get('status');
        if ($request->has('search')) {
            $messages = Messages::search( $request->get('search'),Helper::getPageType($type,$this->types));
            $records = $messages->paginate(20);
        } else if ($request->has('message')) {
            $records = \App\Models\Messages::where('message_id', $request->get('message'))->paginate(1);
        } else {
            $records = Messages::paginate(Helper::findStatusOnParam($type, $this->types), 20, $request->get('status'), $request->get('page'));
        }
        return view('rix.messages')->with([
            'messages' => $records,
            'typeData' => Messages::getTypeData([ 'type' => $type ])
        ]);
    }

    public function action_messages(Request $request)
    {
        if ($request->ajax())
            return Messages::doMessageAction($request->input('data'), $request->input('action'));
    }
}
