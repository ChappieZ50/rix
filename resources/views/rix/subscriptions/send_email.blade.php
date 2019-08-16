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
    <script src="/rix/assets/js/summernote-custom-media.js"></script>
    <script>
        $(function () {
            $('#preview').on('click', function () {
                $('#sendEmailSubscriptionsForm').attr('target', '_blank').attr('action', '{{route('rix.preview_mail')}}').submit();
            });
            $('#sendEmails').on('click', function () {
                if (confirm('Bu işlem kuyruğa alınacaktır ve bittiğinde bilgilendirileceksiniz.'))
                    $('#sendEmailSubscriptionsForm').attr('target','_self').attr('action','{{route('rix.action_send_email_subscriptions')}}').submit();
            });
        });
    </script>
@endsection

@section('section_header_top')
    <div class="section-header-back">
        <a href="{{route('rix.subscriptions')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@section('content')
    @if($errors->any())
        <div class="alert alert-danger pb-1">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @elseif (session()->has('success'))
        <div id="output-status">
            <div class="alert alert-success">{{session('success')}}</div>
        </div>
    @endif
    <form action="{{route('rix.action_send_email_subscriptions')}}" method="post" enctype="multipart/form-data" id="sendEmailSubscriptionsForm">
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
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">E-Posta</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="email" class="form-control" name="email" value="@isset($setting->email){{$setting->email}}@endisset">
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Konu / Başlık</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" name="subject">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mesaj</label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea class="summernote" name="message" id="summernote"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button type="button" class="btn btn-primary" name="sendEmails" id="sendEmails">Gönder</button>
                                    <button type="button" class="btn btn-dark float-right" id="preview">Önizle</button>
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
