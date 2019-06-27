@extends('rix.layouts.master')

@section('page_title','Genel Ayarlar')

@section('title','Genel Ayarlar - Rix Admin')

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

@section('section_header_top')
    <div class="section-header-back">
        <a href="{{route('rix_settings')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Sayfalar</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        {!! \App\Helpers\Helper::createSettingPagesBar([
                        'general_settings' => 'Genel Ayarlar',
                        'image_settings' => 'Görsel Ayarlar',
                        'contact_settings' => 'İletişim Ayarları',
                        'social_media_settings' => 'Sosyal Medya Ayarları',
                        'search_engine_settings' => 'Arama Motoru Ayarları',
                        'site_map' => 'Site Haritası'
                        ],'rix_settings_general') !!}
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form method="post" action="{{route('rix_settings')}}" id="generalSettingsForm">
                @csrf
                <input type="hidden" name="setting_type" value="{{Request::get('setting')}}">
                @if(View::exists('rix.layouts.components.settings.cards.general.'.Request::get('setting')))
                    @include('rix.layouts.components.settings.cards.general.'.Request::get('setting'))
                @else
                    @include('rix.layouts.components.settings.cards.general.general_settings')
                @endif
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('input[name=cookie],input[name=adblock]').on('change', function () {
            $(this).val($(this).is(':checked') ? 1 : 0);
        });
    </script>
@append
