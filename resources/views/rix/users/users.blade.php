@extends('rix.layouts.master')

@section('page_title','Kullanıcılar')

@section('title','Kullanıclıar - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/simple-post.js"></script>
@endsection

@section('section_header_bottom')
    <div class="section-header-button">
        <a href="{{route('rix_user')}}" class="btn btn-primary">Yeni Ekle</a>
    </div>
@endsection

@section('content')
    @include('rix.layouts.components.users.pages-bar')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Kullanıcılar</h4>
                </div>
                <div class="card-body">
                    <div class="float-left">
                        <div class="d-flex justify-content-start align-items-start">
                            <select class="form-control" name="action" data-area="#users"
                                    style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
                                <option>Seçilene Uygula</option>
                                <option value="ban">Yasakla</option>
                                <option value="unban">Yasağı Kaldır</option>
                                <option value="delete">Kalıcı Olarak Sil</option>
                            </select>
                            <button type="button" class="btn btn-sm btn-primary ml-1" style="box-shadow: none;border-radius: 0;" id="apply">
                                Uygula
                            </button>
                        </div>
                    </div>
                    <div class="float-right">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInUsers" placeholder="Kullanıcı Ara" value="{{Request::get('search')}}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="searchInUsersBtn"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    <div class="custom-checkbox custom-control text-center">
                                        <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input"
                                               id="checkbox-records">
                                        <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th>Adı</th>
                                <th>Avatar</th>
                                <th>Rol</th>
                                <th>Oluşturma Tarihi</th>
                                <th>Durum</th>
                            </tr>
                            @if($users->isNotEmpty())
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
                            @endif
                        </table>
                        <div class="pagination float-right mr-3 mt-3">{{$users->appends($_GET)->links()}}</div>
                        @if($users->isEmpty())
                            <div class="pl-3 pb-3">
                                <span style="font-size: 15px;color:gray;">Kullanıcı Bulunamadı</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

