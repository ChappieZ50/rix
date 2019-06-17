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
            <div class="table-links">
                <a href="#" class="text-primary">Düzenle</a>
                <div class="bullet"></div>
                <a href="#">Yasakla</a>
                <div class="bullet"></div>
                <a href="#" class="text-success">Yasağı Kaldır</a>
                <div class="bullet"></div>
                <a href="#" class="text-danger">Kalıcı Olarak Sil</a>
            </div>
        </td>
        <td>
            <img src="/rix/assets/img/avatar/avatar-5.png" class="rounded-circle" width="45">
        </td>
        <td>
            {{$user->role}}
        </td>
        <td>
            {{$user->readable_date}}
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