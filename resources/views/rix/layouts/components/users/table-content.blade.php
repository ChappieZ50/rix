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
            Avatar
        </td>
        <td>
            {{$user->username}}
        </td>
        <td>
            {{$user->role}}
        </td>
        <td>
            @if($user->status === 'ok')
                <div class="badge badge-primary">Aktif</div>
            @else
                <div class="badge badge-danger">Yasaklı</div>
            @endif
        </td>
        <td>{{$user->readable_date}}</td>
        <td>
            <div class="btn-group dropleft">
                <button type="button" class="btn custom-btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"></button>
                <div class="dropdown-menu dropleft actions" data-id="{{$user->user_id}}">
                    <a class="dropdown-item has-icon" href="javascript:;" style="color:green;" id="unban"><i class="ion ion-ios-checkmark"></i>Yasağı Kaldır</a>
                    <a class="dropdown-item has-icon" href="javascript:;" id="ban"><i class="ion ion-android-alert"></i>Yasakla</a>
                    <a class="dropdown-item has-icon" href="javascript:;" id="delete" style="color:red;"><i class="far fa-trash-alt"></i>Kalıcı Olarak Sil</a>
                </div>
            </div>
        </td>
    </tr>
@endforeach
