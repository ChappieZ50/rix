<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Messages;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    protected $types = ['read','unread','trash'];
    public function get_messages(Request $request){
        $type = $request->get('status');
        $typeData = ['type' => $type];
        $paramType = Helper::findStatusOnParam($type,$this->types);
        $messages = Messages::getMessagesWithCount($paramType,$typeData);
        if ($request->get('search')) {
            $value = $request->get('search');
            $messages['messages']->where(function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%')
                    ->orWhere('subject', 'like', '%' . $value . '%')
                    ->orWhere('email', 'like', '%' . $value . '%')
                    ->orWhere('message', 'like', '%' . $value . '%');
            });
        }
        if($request->get('message'))
            $messages['messages']->where('message_id',$request->get('message'));
        return view('rix.messages')->with([
            'messages' => $messages['messages']->paginate(20),
            'typeData' => $messages['count']
        ]);
    }
    public function action_messages(Request $request)
    {
        if ($request->ajax())
            return Messages::doMessageAction($request->input('data'), $request->input('action'));
    }
}
