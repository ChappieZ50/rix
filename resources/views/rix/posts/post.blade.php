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
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">

@endsection

{{-- General JS --}}
@section('general_js')
    <script src="/rix/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
    <script src="/rix/assets/modules/summernote/dist/summernote-bs4.js"></script>
    <script src="/rix/assets/modules/summernote/dist/lang/summernote-tr-TR.min.js"></script>
    <script src="/rix/assets/modules/codemirror/lib/codemirror.js"></script>
    <script src="/rix/assets/modules/codemirror/mode/javascript/javascript.js"></script>
    @isset($post)
        <script src="/rix/assets/js/page/update-post.js"></script>
    @else
        <script src="/rix/assets/js/page/new-post.js"></script>
    @endisset
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    {{-- <script>
       window.onbeforeunload = function () { return "alert" };
    </script>--}}
@endsection

{{-- JS --}}
@section('js')
    <script src="/rix/assets/modules/selectric/public/jquery.selectric.js"></script>
    <script>
        $(function () {
            let button =
                '<div class="d-flex justify-content-center align-items-center mb-4">' +
                '<button type="button" class="btn btn-primary" data-toggle="modal"' +
                'data-target="#mediaModal" data-before="0" data-url="{{route("rix_gallery")}}"' +
                'id="add_image" data-position="summernote" style="box-shadow:0;border-radius:0;width:100%;padding:10px;">Resim Seç</button>' +
                '</div>';
            let images = $('.note-group-select-from-files');
            images.html(
                button +
                '<div class="text-center"><h6>Veya</h6></div>'
            );
            // Modal Fix modal backdrop
            $('#mediaModal').appendTo("body");
        })
    </script>
@endsection

@section('section_header_top')
    <div class="section-header-back">
        <a href="{{route('rix_posts')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@section('content')
    <div class="row @isset($post) ? updatePost @else newPost @endisset">
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
                        @include('rix.layouts.components.posts.cards.general')
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>SEO</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse3" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse3">
                    <div class="card-body">
                        @include('rix.layouts.components.posts.cards.seo')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Öne çıkan resim</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse1" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse1">
                    <div class="card-body">
                        @include('rix.layouts.components.posts.cards.featured-image')
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Kategoriler / Etiketler</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        @include('rix.layouts.components.posts.cards.categories-tags')
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
                        @include('rix.layouts.components.posts.cards.publish')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('rix.layouts.components.media-modal')
@endsection
