<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Users;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function get_users(Request $request)
    {
        $type = [ 'type' => $request->get('type') ];
        if ($type['type'] === 'banned')
            $data = Users::getUsersWithCount([ 'whereColumn' => 'status', 'whereValue' => 'banned' ], $type);
        else
            $data = Users::getUsersWithCount([ 'whereColumn' => 'role', 'whereValue' => $type['type'] ], $type);
        if ($request->get('search')) {
            $search = $request->get('search');
            $data['users']->where(function ($query) use ($search) {
                $query->where('username', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $data['admins'] = Users::getUsers();
        return view('rix.users.users')->with([
            'typeData' => $data['count'],
            'users'    => $data['users']->withCount([
                'post' => function ($query) {
                    $query->where('status', '!=', 'trash');
                } ])->paginate(20),
            'admins'   => $data['admins']->whereIn('role', [ 'admin', 'editor' ])->where('user_id', '!=', 1)->get(),
        ]);
    }

    public function get_user($id = '')
    {
        $view = view('rix.users.user');
        if (!empty($id)) {
            $users = Users::getUsers();
            $user = $users->where('user_id', $id)->first();
            if (!empty($user))
                return $view->with('user', $user);
            return abort(404);
        }
        return $view;
    }

    public function action_users(Request $request)
    {
        if ($request->ajax())
            return Users::actionUsers($request);
    }

    public function action_user(Request $request)
    {
        if ($request->has('id'))
            return Users::updateUser($request);
        else
            return Users::createUser($request);
    }
}
