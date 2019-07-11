@extends('rix.layouts.master')

@section('page_title','Abonelere Mail Gönder')

@section('title','Abonelere Mail Gönder - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="/rix/assets/modules/summernote/dist/summernote-bs4.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('general_js')
    <script src="/rix/assets/modules/summernote/dist/summernote-bs4.js"></script>
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/simple-post.js"></script>
    <script src="/rix/assets/js/summernote-custom-media.js"></script>
@endsection

@section('section_header_top')
    <div class="section-header-back">
        <a href="{{route('rix_subscriptions')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@section('content')
    <form action="{{route('rix_action_send_email_subscriptions')}}" method="post" enctype="multipart/form-data" id="sendEmailSubscriptionsForm">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bilgiler</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                        class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse">
                        @php $setting = isset($setting->email) ?  json_decode($setting->email) : $setting @endphp
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Ad Soyad</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}">
                                    <div class="invalid-feedback d-block" data-name="name" style="margin-top: -20px;margin-bottom: 10px;"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">E-Posta</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="email" class="form-control" name="email" value="@isset($setting->email){{$setting->email}}@endisset">
                                    <div class="invalid-feedback d-block" data-name="email" style="margin-top: -20px;margin-bottom: 10px;"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Telefon (İsteğe Bağlı)</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" name="phone">
                                    <div class="invalid-feedback d-block" data-name="phone" style="margin-top: -20px;margin-bottom: 10px;"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mesaj</label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea class="summernote" id="summernote"></textarea>
                                    <div class="invalid-feedback d-block" data-name="message" style="margin-top: -20px;margin-bottom: 10px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('rix.layouts.components.media-modal')
@endsection

