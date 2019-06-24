@extends('rix.layouts.master')

@section('page_title','Profil')

@section('title','Profil - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/page/profile.js"></script>
    <script>
        @if(Request::get('status') == 'success')
            iziToast.success({
                title: 'Başarılı',
                message: 'Profilin Başarıyla Güncellendi',
                position: 'topRight',
            });
        @endif
        window.history.pushState({}, document.title, removeURLParameter('{!! url()->full() !!}', 'status'));
    </script>
@endsection


@section('content')
    <form action="{{route('rix_profile')}}" method="post" enctype="multipart/form-data" id="profileForm">
        @csrf
        <div class="row profile">
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
                        <div class="card-body profile">
                            <div class="col-sm-12 text-center">
                                <button type="submit" name="update" class="btn btn-primary" id="publish">Güncelle</button>
                                <button type="button" class="btn disabled btn-primary btn-progress" style="display: none;">Progress</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

