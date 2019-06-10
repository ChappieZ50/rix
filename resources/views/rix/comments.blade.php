@extends('rix.layouts.master')

@section('page_title','Yorumlar')

@section('title','Yorumlar - Rix Admin')

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

@section('content')
    <div class="card">
        <div class="d-flex justify-content-start align-items-start p-3">
            <select class="form-control" name="action" data-area="#comments"
                    style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
                <option>Seçilene Uygula</option>
                <option value="approve">Onayla</option>
                <option value="unapprove">Onaylama</option>
                <option value="delete">Sil</option>
            </select>
            <button type="button" class="btn btn-sm btn-primary ml-1" style="box-shadow: none;border-radius: 0;" id="apply">
                Uygula
            </button>
        </div>
        <div class="table-pages-bar" id="tablePagesBar">
            @include('rix.layouts.components.comments.pages-bar')
        </div>
        <div class="card-header">
            <h4>Yorumlar</h4>
            <div class="card-header-form">
                <div class="input-group">
                    <button type="button" class="btn custom-btn-dark mr-2" style="display: none;" id="closeSearch">Aramadan Çık
                    </button>
                    <input type="text" class="form-control" id="searchInComments" placeholder="Yorum Ara...">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" id="searchCommentBtn" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0" id="commentsTable">
            @include('rix.layouts.components.comments.table')
        </div>
    </div>
@endsection

