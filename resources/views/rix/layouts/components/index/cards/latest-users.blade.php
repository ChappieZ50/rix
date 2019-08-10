<div class="col-lg-6 col-md-12 col-12 col-sm-12">
    <div class="card shadow-dark shadow-sm">
        <div class="card-header">
            <h4>Son Üye Olan Kullanıcılar</h4>
            <div class="card-header-action">
                <a href="{{route('rix_users')}}" class="btn btn-primary">Hepsini Göster</a>
            </div>
        </div>
        @if($records['users']->isEmpty())
            <div class="text-center m-3">Bir Sorun Oluştu</div>
        @else
            <div class="card-body p-0 ">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 25%;">Kullanıcı Adı</th>
                            <th>İsmi</th>
                            <th>Avatar</th>
                            <th>Rol</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records['users'] as $user)
                            <tr>
                                <td>{{$user->user_id}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->name}}</td>
                                <td>
                                    {!! \App\Helpers\Helper::getUserAvatar($user->avatar,$user->role) !!}
                                </td>
                                <td>
                                    {{\App\Helpers\Helper::getUserRole($user->role)}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>