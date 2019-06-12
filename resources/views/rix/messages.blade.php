@extends('rix.layouts.master')

@section('page_title','Mesajlar')

@section('title','Mesajlar - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/simple-post.js"></script>
    <script src="/rix/assets/js/page/messages.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="d-flex justify-content-start align-items-start p-3">
            <select class="form-control" name="action" data-area="#messages"
                    style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
                <option>Seçilene Uygula</option>
                <option value="read">Okundu</option>
                @if(Request::get('status') !== 'unread')
                    <option value="unread">Okunmadı</option>
                @endif
                @if(Request::get('status') === 'trash')
                    <option value="untrash">Geri Al</option>
                    <option value="delete">Kalıcı Olarak Sil</option>
                @else
                    <option value="trash">Çöpe Taşı</option>
                @endif
            </select>
            <button type="button" class="btn btn-sm btn-primary ml-1" style="box-shadow: none;border-radius: 0;" id="apply">
                Uygula
            </button>
        </div>
        <div class="table-pages-bar" id="tablePagesBar">
            @include('rix.layouts.components.messages.pages-bar')
        </div>
        <div class="card-header">
            <h4>Mesajlar</h4>
            <div class="card-header-form">
                <div class="input-group">
                    <button type="button" class="btn custom-btn-dark mr-2" style="display: none;" id="closeSearch">Aramadan Çık
                    </button>
                    <input type="text" class="form-control" id="searchInMessages" placeholder="Mesaj Ara..." value="{{Request::get('search')}}">
                    <div class="input-group-btn">
                        <button class="btn btn-primary" id="searchInMessagesBtn" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0" id="messagesTable">
            @include('rix.layouts.components.messages.table')
        </div>
    </div>
@endsection

