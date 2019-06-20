<?php

namespace App\Classes;

use App\Models\Users as ModelUsers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic;

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
        $validator = self::validateUser($request);
        if ($validator->isNotEmpty())
            return Helper::response(false, '', [ 'errors' => $validator ]);
        $slug = Str::slug($request->input('username'));
        $password = Hash::make($request->input('password'));
        if ($request->hasFile('avatar'))
            $avatar = self::createAvatar($request->file('avatar'));

        $create = ModelUsers::create([
            'name'          => $request->input('name'),
            'slug'          => Helper::slugPrefix($slug, new ModelUsers()),
            'username'      => $request->input('username'),
            'avatar'        => isset($avatar) ? $avatar->avatarName : null,
            'avatar_data'   => isset($avatar) ? $avatar->avatarData : null,
            'email'         => $request->input('email'),
            'password'      => $password,
            'role'          => $request->input('role'),
            'readable_date' => Helper::readableDateFormat()
        ]);
        if ($create)
            return Helper::response(true, 'Kullanıcı Başarıyla Eklendi');
        return Helper::response(false, 'Bir Sorun Oluştu');
    }

    static function updateUser($request)
    {
        $id = $request->input('id');
        $user = ModelUsers::where('user_id', $id)->first();
        if (!empty($user)) {
            $data = [];
            $validate = [
                'username' => [ 'required', 'max:255', Rule::unique('rix_users')->ignore($user->user_id, 'user_id') ],
                'email'    => [ 'required', 'email', 'max:255', Rule::unique('rix_users')->ignore($user->user_id, 'user_id') ],
            ];
            if ($request->has('password')) {
                $password = Hash::make($request->input('password'));
                $validate = array_merge($validate, [ 'password' => 'required|min:6|max:255|confirmed' ]);
                $data['password'] = $password;
            } else {
                $validate = array_merge($validate, [ 'password' => 'nullable' ]);
            }
            $validator = self::validateUser($request, $validate);
            if ($validator->isNotEmpty())
                return Helper::response(false, '', [ 'errors' => $validator ]);
            if ($request->hasFile('avatar'))
                $avatar = self::createAvatar($request->file('avatar'));
            $data = $data + [
                    'username'      => $request->input('username'),
                    'email'         => $request->input('email'),
                    'name'          => $request->input('name'),
                    'slug'          => Helper::slugPrefix(Str::slug($request->input('username')), new ModelUsers(), [ 'idColumn' => 'user_id', 'id' => $user->user_id ]),
                    'role'          => $request->input('role'),
                    'readable_date' => Helper::readableDateFormat(),
                    'avatar'        => isset($avatar) ? $avatar->avatarName : $user->avatar,
                    'avatar_data'   => isset($avatar) ? $avatar->avatarData : $user->avatar_data,
                ];
            if (isset($avatar) && File::exists(public_path('storage/avatars/') . $user->avatar))
                File::delete(public_path('storage/avatars/') . $user->avatar);
            if (ModelUsers::where('user_id', $user->user_id)->update($data))
                return Helper::response(true, 'Kullanıcı Başarıyla Güncellendi');
            return Helper::response(false, 'Bir Sorun Oluştu');
        }
    }

    static function createAvatar($avatar)
    {
        $noExtensionName = Helper::uniqImg();
        $avatarName = Helper::uniqImg([ 'extension' => $avatar->getClientOriginalExtension() ], $noExtensionName);
        $avatarData = Helper::getImageData($avatar, $avatarName, $noExtensionName);
        $img = ImageManagerStatic::make($avatar->getRealPath());
        $img->resize(200, 200)->save(public_path('storage/avatars/') . $avatarName);
        return (object)[
            'avatarData' => $avatarData,
            'avatarName' => $avatarName,
        ];
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

    static function actionUsers($request)
    {
        if ($request->input('action') === 'transfer') {
            $data = (object) $request->input('data');
            $user = \App\Models\Posts::where('author_id', $data->deleteID)->update([
                'author_id' => $data->transferID
            ]);
            if ($user)
                if (ModelUsers::where('user_id', $data->deleteID)->delete())
                    return Helper::response(true,'Transfer İşlemi Başarıyla Tamamlandı');
                else
                    return Helper::response(false,'Kullanıcı Silinemedi');
            else
                return Helper::response(false,'Yazılar Güncellenemedi');

        }

        $ids = Helper::getIds($request->input('data'));
        if (!empty($ids)) {
            if ($request->input('action') === 'delete') {
                return ModelUsers::destroy($ids);
            } else {
                foreach ($ids as $id) {
                    $user = ModelUsers::where('user_id', $id)->select('user_id', 'created_at', 'status_data', 'status')->first();
                    if (!empty($user)) {
                        $find = ModelUsers::where('user_id', $user->user_id);
                        $statusData = json_decode($user->status_data);
                        if ($request->input('action') === 'ban' && $user->status !== 'banned') {
                            $find->update([
                                'status'      => 'banned',
                                'status_data' => self::createUserStatusData(isset($statusData->prohibition) ? $statusData->prohibition : 0)
                            ]);
                        } elseif ($request->input('action') === 'unban' && $user->status === 'banned') {
                            $find->update([
                                'status'      => 'ok',
                                'status_data' => self::updateUserStatusData(isset($statusData->bannedTime) ? $statusData->bannedTime : null, isset($statusData->prohibition) ? $statusData->prohibition : 1)
                            ]);
                        }
                    }
                }
            }
        }
    }

    static function createUserStatusData($prohibition)
    {
        return json_encode([
            'bannedReadableTime' => Helper::readableDateFormat('%d %B %Y %H:%M'),
            'bannedTime'         => date('Y-m-d H:i:s'),
            'status'             => 'Yasaklı',
            'prohibition'        => $prohibition + 1,
        ]);
    }

    static function updateUserStatusData($bannedTime, $prohibition)
    {
        return json_encode([
            'unbannedReadableTime' => Helper::readableDateFormat('%d %B %Y %H:%M'),
            'unbannedTime'         => date('Y-m-d H:i:s'),
            'prohibitedTime'       => Helper::getTimeDiff($bannedTime),
            'prohibition'          => $prohibition,
            'status'               => 'Yasak Kaldırıldı',
        ]);
    }
}