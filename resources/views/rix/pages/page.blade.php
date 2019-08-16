@extends('rix.layouts.master')

@section('page_title')
    @if(Request::route('id') && isset($page))
        {{$page->title}}
    @else
        Sayfa Ekle
    @endif
@endsection

@section('title',Request::route('id') && isset($page) ? $page->title.' Düzenleniyor - Rix Admin' : 'Sayfa Ekle - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="/rix/assets/modules/summernote/dist/summernote-bs4.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
    <link rel="stylesheet" href="/rix/assets/css/tagify.css">
@endsection

@section('general_js')
    <script src="/rix/assets/modules/summernote/dist/summernote-bs4.js"></script>
    <script src="/rix/assets/js/tagify.min.js"></script>
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/summernote-custom-media.js"></script>
    <script src="/rix/assets/js/page/pages.js"></script>
    <script>
        @if(Request::route('id'))
            @if(Request::get('status') == 'success')
            iziToast.success({
                title: 'Başarılı',
                message: '{{Request::get('action') == 'insert' ? 'Sayfa Başarıyla Eklendi' : 'Sayfa Başarıyla Güncellendi'}}',
                position: 'topRight',
            });
            @endif
            let url = '{!! url()->full() !!}';
            url = removeURLParameter(url,'status');
            url = removeURLParameter(url,'action');
            window.history.pushState({}, document.title, url);
        @endif
    </script>
@endsection

@section('section_header_top')
    <div class="section-header-back">
        <a href="{{route('rix.pages')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@section('content')
    <form action="{{route('rix.action_page')}}" method="post" enctype="multipart/form-data" id="pageForm">
        @csrf
        <div class="row @isset($page) updatePage @else newPage @endisset">
            @isset($page)<input type="hidden" name="id" value=" {{$page->page_id}}"> @endisset
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
                            @include('rix.layouts.components.pages.cards.general')
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
                            @include('rix.layouts.components.pages.cards.seo')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Öne Çıkan Resim</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse4" class="btn btn-icon btn-info" href="#"><i
                                        class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse4">
                        <div class="card-body">
                            @include('rix.layouts.components.pages.cards.featured')
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
                            @include('rix.layouts.components.pages.cards.publish')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('rix.layouts.components.media-modal')
@endsection

