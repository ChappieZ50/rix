<?php

namespace App\Classes;

use App\Models\Users as ModelUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Helpers\Helper;

class Users
{
    static function validateUser($request, $validate = [])
    {
        $defaultValidate = [
            'name'     => 'required|max:255',
            'username' => 'required|unique:rix_users|max:255',
            'email'    => 'required|email|unique:rix_users|max:255',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024',
            'password' => 'required|min:6|max:255|confirmed',
            'role'     => 'required'
        ];
        $validate = array_merge($defaultValidate, $validate);
        $validator = \Validator::make($request->all(), $validate);
        return $validator->errors();
    }

    static function getUsers($options = [])
    {
        $defaults = [
            'whereColumn'     => '',
            'whereValue'      => '',
            'with'            => '',
            'withSelect'      => '',
            'wherePostColumn' => '',
            'wherePostValue'  => '',
            'order'           => 'role',
            'orderBy'         => 'asc',
        ];
        $options = array_merge($defaults, $options);
        $users = new ModelUsers();
        if (!empty($options['whereColumn']) && !empty($options['whereValue'])) {
            $options['whereValue'] = !is_array($options['whereValue']) ? explode(',', $options['whereValue']) : $options['whereValue'];
            $users = $users->whereIn($options['whereColumn'], $options['whereValue']);
        }
        if (!empty($options['wherePostColumn']) && !empty($options['wherePostValue'])) {
            $users = $users->whereHas('post', function ($query) use ($options) {
                $options['wherePostValue'] = !is_array($options['wherePostValue']) ? explode(',', $options['wherePostValue']) : $options['wherePostValue'];
                return $query->whereIn($options['wherePostColumn'], $options['wherePostValue']);
            });
        }
        $users = !empty($options['with']) ? $users->with([
            $options['with'] => function ($query) use ($options) {
                return $query->select(!empty($options['withSelect']) ? $options['withSelect'] : [ '*' ]);
            } ]) : $users;
        return $users->orderBy($options['order'], $options['orderBy']);
    }

    static function createUser($request)
    {
        $slug = Str::slug($request->input('username'));
        $password = Hash::make($request->input('password'));
        if ($request->hasFile('avatar')) {
            $noExtensionName = Helper::uniqImg();
            $avatarName = Helper::uniqImg([ 'extension' => $request->file('avatar')->getClientOriginalExtension() ], $noExtensionName);
            $avatarData = Helper::getImageData($request->file('avatar'), $avatarName, $noExtensionName);
            $request->file('avatar')->move(public_path('storage/avatars'), $avatarName);
        }
        $create = ModelUsers::create([
            'name'          => $request->input('name'),
            'slug'          => $slug,
            'username'      => $request->input('username'),
            'avatar'        => isset($avatarName) ? $avatarName : null,
            'avatar_data'   => isset($avatarData) ? $avatarData : null,
            'email'         => $request->input('email'),
            'password'      => $password,
            'role'          => $request->input('role'),
            'readable_date' => Helper::readableDateFormat()
        ]);
        if ($create)
            return Helper::response(true, 'Kullanıcı Başarıyla Eklendi');
        return Helper::response(false, 'Bir Sorun Oluştu');
    }

    static function getTypeData($custom = [])
    {
        $admin = [ 'whereColumn' => 'role', 'whereValue' => 'admin' ];
        $editor = [ 'whereColumn' => 'role', 'whereValue' => 'editor' ];
        $user = [ 'whereColumn' => 'role', 'whereValue' => 'user' ];
        $banned = [ 'whereColumn' => 'status', 'whereValue' => 'banned' ];

        $typeData = [
            'all'    => self::getUsers()->count(),
            'admin'  => self::getUsers($admin)->count(),
            'editor' => self::getUsers($editor)->count(),
            'user'   => self::getUsers($user)->count(),
            'banned' => self::getUsers($banned)->count()
        ];
        if (!empty($custom))
            $typeData = array_merge($typeData, $custom);
        return (object)$typeData;
    }

    static function getUsersWithCount($options = [], $custom = [])
    {
        $count = self::getTypeData($custom);
        $users = self::getUsers($options);
        return [
            'users' => $users,
            'count' => $count
        ];
    }
}