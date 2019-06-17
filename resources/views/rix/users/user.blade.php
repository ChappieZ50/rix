@extends('rix.layouts.master')

@section('page_title','Kullanıcı Ekle')

@section('title','Kullanıcı Ekle - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/simple-post.js"></script>
    <script src="/rix/assets/js/page/user.js"></script>
    <script>
        @if(Request::route('id'))
            @if(Request::get('status') == 'success')
                iziToast.success({
                    title: 'Başarılı',
                    message: 'Kullanıcı Başarıyla Eklendi',
                    position: 'topRight',
                });
            @endif
        window.history.pushState({}, document.title, removeURLParameter('{!! url()->full() !!}', 'status'));
        @endif
    </script>
@endsection

@section('section_header_top')
    <div class="section-header-back">
        <a href="{{route('rix_users')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@section('content')
    <form action="{{route('rix_action_user')}}" method="post" enctype="multipart/form-data" id="userForm">
        @csrf
        <div class="row @isset($user) updateUser @else newUser @endisset">
            @isset($user)<input type="hidden" name="user_id" value=" {{$user->user_id}}"> @endisset
            <div class="col-xl-9 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bilgiler</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                        class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse">
                        <div class="card-body">
                            @include('rix.layouts.components.users.cards.general')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Avatar</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse4" class="btn btn-icon btn-info" href="#"><i
                                        class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse4">
                        <div class="card-body">
                            @include('rix.layouts.components.users.cards.avatar')
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Yayınla</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse4" class="btn btn-icon btn-info" href="#"><i
                                        class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse4">
                        <div class="card-body">
                            @include('rix.layouts.components.users.cards.publish')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

