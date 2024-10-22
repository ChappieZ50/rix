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
    <script src="/rix/assets/js/page/user.js"></script>
@endsection

@section('section_header_bottom')
    <div class="section-header-button">
        <a href="{{route('rix.user')}}" class="btn btn-primary">Yeni Ekle</a>
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
                    <div class="float-right">
                        <div class="input-group">
                            <button type="button" class="btn custom-btn-dark mr-2" style="{{Request::get('search') ? 'display: show;' : 'display: none;'}}" id="closeSearch">
                                Aramadan Çık
                            </button>
                            <input type="text" class="form-control" id="searchInUsers" placeholder="Kullanıcı Ara" value="{{Request::get('search')}}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="searchInUsersBtn"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive usersTable">
                        @include('rix.layouts.components.users.table')
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

