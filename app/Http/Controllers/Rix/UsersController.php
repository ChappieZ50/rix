<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Users;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    protected $types = [
        'admin',
        'editor',
        'user',
        'banned',
    ];

    public function get_users(Request $request)
    {

        $type = $request->get('type');
        if ($request->has('search')) {
            $users = Users::search($request->get('search'), Helper::getPageType($type, $this->types));;
            $records = $users->paginate(20);
        } else {
            $records = Users::paginate(array_merge(Helper::findStatusOnParam($type, $this->types), [ 'whereColumn' => 'role' ]), 20, $request->get('type'), $request->get('page'));
        }
        return view('rix.users.users')->with([
            'typeData' => Users::getTypeData([ 'type' => $type ]),
            'users'    => $records,
            'admins'   => Users::getAdmins(),
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
