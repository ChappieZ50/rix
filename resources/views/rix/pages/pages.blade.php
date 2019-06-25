@extends('rix.layouts.master')

@section('page_title','Sayfalar')

@section('title','Sayfalar - Rix Admin')

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
        <a href="{{route('rix_page')}}" class="btn btn-primary">Yeni Ekle</a>
    </div>
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Sayfalar</h4>
                </div>
                <div class="card-body">
                    <div class="float-right">
                        <div class="input-group">
                            <button type="button" class="btn custom-btn-dark mr-2" style="{{Request::get('search') ? 'display: show;' : 'display: none;'}}" id="closeSearch">
                                Aramadan Çık
                            </button>
                            <input type="text" class="form-control" id="searchInPages" placeholder="Sayfa Ara" value="{{Request::get('search')}}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="searchInPagesBtn"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive pagesTable">
                        @include('rix.layouts.components.pages.table')
                        <div class="pagination float-right mr-3 mt-3">{{$users->appends($_GET)->links()}}</div>
                        @if($users->isEmpty())
                            <div class="pl-3 pb-3">
                                <span style="font-size: 15px;color:gray;">Sayfa Bulunamadı</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

