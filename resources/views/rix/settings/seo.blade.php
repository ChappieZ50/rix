@extends('rix.layouts.master')

@section('page_title','Seo Ayarları')

@section('title','Seo Ayarları - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
@endsection

@section('section_header_top')
    <div class="section-header-back">
        <a href="{{route('rix.settings.setting')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@section('content')
    @include('rix.layouts.components.status-message')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Sayfalar</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item"><a href="javascript:;" class="nav-link active">SEO</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form method="post" action="{{route('rix.settings.seo')}}" id="seoSettingsForm">
                @csrf
                <input type="hidden" name="setting_type" value="{{!Request::get('setting') ? 'seo' : Request::get('setting')}}">
                @include('rix.layouts.components.settings.cards.seo.seo')
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('input[name=status_site_name]').on('change', function () {
            $(this).val($(this).is(':checked') ? 1 : 0);
        });
    </script>
@append
