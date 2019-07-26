@extends('rix.layouts.master')

@section('page_title','Bülten')

@section('title','Bülten - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/page/subscriptions.js"></script>
@endsection

@section('section_header_bottom')
    <div class="section-header-button">
        <a href="{{route('rix_send_email_subscriptions')}}" class="btn btn-primary">Abonelere Mail Gönder</a>
    </div>
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Abonelikler</h4>
                </div>
                <div class="card-body">
                    <div class="float-left">
                        <div class="d-flex justify-content-start align-items-start">
                            <select class="form-control" name="action" data-area="#subscriptions"
                                    style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
                                <option value="">Seçilene Uygula</option>
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
                            <input type="text" class="form-control" id="searchInSubscriptions" placeholder="Abonelik Ara" value="{{Request::get('search')}}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="searchInSubscriptionsBtn"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix mb-3"></div>
                    <div class="table-responsive subscriptionsTable">
                        @include('rix.layouts.components.subscriptions.table')

                        <div class="pagination float-right mr-3 mt-3">{{$subscriptions->appends($_GET)->links()}}</div>
                        @if($subscriptions->isEmpty())
                            <div class="pl-3 pb-3">
                                <span style="font-size: 15px;color:gray;">Abonelik Bulunamadı</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

