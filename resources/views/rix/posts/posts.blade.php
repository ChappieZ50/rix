@extends('rix.layouts.master')

@section('page_title','Yazılar')

@section('title','Yazılar - Rix Admin')

@section('section_header_bottom')
    <div class="section-header-button">
        <a href="{{route('rix_new_post')}}" class="btn btn-primary">Yeni Ekle</a>
    </div>
@endsection

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/simple-post.js"></script>
    <script src="/rix/assets/js/page/posts.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="d-flex justify-content-start align-items-start p-3">
            <select class="form-control" name="action" data-area="#posts" style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
                <option>Seçilene Uygula</option>
                @if(Request::get('type') == 'trash')
                    <option value="restore">Geri Al</option>
                    <option value="delete">Kalıcı Olarak Sil</option>
                @else
                    <option value="trash">Çöpe Taşı</option>
                @endif
            </select>
            <button type="button" class="btn btn-sm btn-primary ml-1" style="box-shadow: none;border-radius: 0;" id="apply">Uygula</button>
        </div>
        <div class="table-pages-bar" id="tablePagesBar">
            @include('rix.layouts.components.posts.posts.table-pages-bar')
        </div>
        <div class="card-header">
            <h4>Yazılar</h4>
            <div class="card-header-form">
                <div class="input-group">
                    <button type="button" class="btn custom-btn-dark mr-2" style="{{Request::get('search') ? 'display: show;' : 'display: none;'}}" id="closeSearch">Aramadan Çık</button>
                    <input type="text" class="form-control" id="searchInPosts" placeholder="Yazı Ara..." value="{{Request::get('search')}}">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" id="searchPostsBtn" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0" id="postsTable">
            @include('rix.layouts.components.posts.posts.posts-table')
        </div>
    </div>
@endsection

