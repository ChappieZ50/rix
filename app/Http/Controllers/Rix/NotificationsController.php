<?php

namespace App\Http\Controllers\Rix;

use App\Helpers\Helper;
use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    public function action_notifications(Request $request)
    {
        if ($request->has('status')) {
            Helper::forget('COMPOSE','NOTIFICATIONS');
            if (Notifications::truncate())
                return [ 'status' => true ];
        }
    }
}
