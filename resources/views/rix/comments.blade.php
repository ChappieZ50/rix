@extends('rix.layouts.master')
@section('page_title')
    @if(Request::get('post'))
        @isset($comments->toArray()['data'][0]['post']['title']) <a href="{{$comments->toArray()['data'][0]['post']['url']}}"
                                                                    target="_blank">{{\App\Helpers\Helper::longText($comments->toArray()['data'][0]['post']['title'],['len' => 30])}}</a>  Yazısının Yorumları @else Yorumlar  @endisset
    @else
        Yorumlar
    @endif
@endsection
@if(Request::get('post'))
@section('section_header_top')
    <div class="section-header-back">
        <a href="{{route('rix.comments')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@endif
@section('title','Yorumlar - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/page/comments.js"></script>
@endsection

@section('content')
    @include('rix.layouts.components.comments.pages-bar')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Yorumlar</h4>
                </div>
                <div class="card-body">
                    <div class="float-left">
                        <div class="d-flex justify-content-start align-items-start">
                            <select class="form-control" name="action" data-area="#comments"
                                    style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
                                <option value="">Seçilene Uygula</option>
                                @if(Request::get('status') != 'pending')
                                    <option value="pending">Onayı Kaldır</option>
                                @endif
                                @if(Request::get('status') != 'approved')
                                    <option value="approved">Onayla</option>
                                @endif
                                @if(Request::get('status') != 'spam')
                                    <option value="spam">Spam Olarak İşaretle</option>
                                @else
                                    <option value="unspam">Spamdan Kaldır</option>
                                @endif
                                <option value="delete">Kalıcı Olarak Sil</option>
                            </select>
                            <button type="button" class="btn btn-sm btn-primary ml-1" style="box-shadow: none;border-radius: 0;" id="apply">
                                Uygula
                            </button>
                        </div>
                    </div>
                    <div class="float-right">
                        <div class="input-group">
                            <button type="button" class="btn custom-btn-dark mr-2" style="{{Request::get('search') ? 'display: show;' : 'display: none;'}}" id="closeSearch">
                                Aramadan Çık
                            </button>
                            <input type="text" class="form-control" id="searchInComments" placeholder="Yorum Ara" value="{{Request::get('search')}}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="searchCommentBtn"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive commentsTable">
                        @include('rix.layouts.components.comments.table')
                        <div class="pagination float-right mr-3 mt-3">{{$comments->appends($_GET)->links()}}</div>
                        @if($comments->isEmpty())
                            <div class="pl-3 pb-3">
                                <span style="font-size: 15px;color:gray;">Yorum Bulunamadı</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

