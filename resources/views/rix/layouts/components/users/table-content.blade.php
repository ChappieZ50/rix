@foreach($users as $user)
    <tr>
        <td class="p-0 text-center">
            <div class="custom-checkbox custom-control">
                <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$user->user_id}}"
                       id="checkbox-{{$user->user_id}}">
                <label for="checkbox-{{$user->user_id}}" class="custom-control-label">&nbsp;</label>
            </div>
        </td>
        <td>
            {{$user->username}}
            <div class="table-links actions" data-id="{{$user->user_id}}">
                <a href="{{action('Rix\UsersController@get_user',$user->user_id)}}" class="text-primary" id="edit">Düzenle</a>
                <div class="bullet"></div>
                @if(Request::get('type') === 'banned' || $user->status === 'banned')
                    <a href="#" class="text-success" id="unban">Yasağı Kaldır</a>
                    <div class="bullet"></div>
                @else
                    <a href="#" class="text-dark" id="ban">Yasakla</a>
                    <div class="bullet"></div>
                @endif
                <a href="javascript:;" class="text-danger" id="delete" @if($user->post_count > 0) data-target="post" @endif>Kalıcı Olarak Sil</a>
            </div>
        </td>
        <td>
            {{$user->name}}
        </td>
        <td>
            @if(empty($user->avatar))
                <img src="/rix/assets/img/avatar/avatar-5.png" width="50">
            @else
                <img src="{{url('storage/avatars/'.$user->avatar)}}" width="50">
            @endif
        </td>
        <td>
            @if($user->role === 'admin')
                Yönetici
            @elseif ($user->role === 'editor')
                Yazar
            @else
                Kullanıcı
            @endif
        </td>
        <td>
            {{$user->readable_date}}
        </td>
        <td>
            {{$user->post_count}}
        </td>
        <td>
            @if($user->status === 'ok')
                <div class="badge badge-primary">Aktif</div>
            @else
                <div class="badge badge-danger">Yasaklı</div>
            @endif
        </td>
    </tr>
@endforeach
@include('rix.layouts.components.users.move-modal')