@extends('rix.layouts.master')

@section('page_title','Yazı Ekle')

@section('title','Yazı Ekle - Rix Admin')

{{-- General CSS --}}
@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/chocolat/dist/css/chocolat.css">
    <link rel="stylesheet" href="/rix/assets/modules/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet" href="/rix/assets/modules/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="/rix/assets/modules/codemirror/theme/duotone-dark.css">
    <link rel="stylesheet" href="/rix/assets/modules/selectric/public/selectric.css">
@endsection

{{-- General JS --}}
@section('general_js')
    <script src="/rix/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

    <script src="/rix/assets/modules/summernote/dist/summernote-bs4.js"></script>
    <script src="/rix/assets/modules/codemirror/lib/codemirror.js"></script>
    <script src="/rix/assets/modules/codemirror/mode/javascript/javascript.js"></script>
    <script src="/rix/assets/modules/selectric/public/jquery.selectric.min.js"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Bilgiler</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                        @include('rix.layouts.components.blog.card1')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>SEO</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse1" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse1">
                    @include('rix.layouts.components.blog.card2')
                </div>
            </div>
        </div>
    </div>
@endsection
