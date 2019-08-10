@extends('rix.layouts.master')

@section('page_title','Ayarlar')

@section('title','Ayarlar - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
@endsection


@section('content')
    <h2 class="section-title">Dikkat</h2>
    <p class="section-lead">
        Bazı şeylerin doğru çalışabilmesi için bunları yapmanız gerekmektedir.
        <br>
        Cron'a eklemeniz gereken kod: <span class="text-primary">/usr/bin/php "Artisan dosyasının bulunduğu dosya yolu" schedule:run  >/dev/null 2>&1</span>
        <br>
        Php.ini'ye eklemeniz gereken kod: <span class="text-primary">register_argc_argv=on</span>
    </p>
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-large-icons col-12 p-0">
                <div class="card-icon bg-primary text-white">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="card-body">
                    <h4>Genel</h4>
                    <p>Panel adı, doğrulamalar , adres vb. ayarlar.</p>
                    <a href="{{route('rix_settings_general')}}" class="card-cta">Ayarları Değiştir <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-large-icons col-12 p-0">
                <div class="card-icon bg-primary text-white">
                    <i class="fas fa-search"></i>
                </div>
                <div class="card-body">
                    <h4>SEO</h4>
                    <p>Meta etiketleri ve sosyal medya gibi arama motoru optimizasyonu ayarları.</p>
                    <a href="{{route('rix_settings_seo')}}" class="card-cta">Ayarları Değiştir <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-large-icons col-12 p-0">
                <div class="card-icon bg-primary text-white">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="card-body">
                    <h4>E-Posta</h4>
                    <p>E-posta SMTP ayarları ve e-posta ile ilgili diğer bilgiler.</p>
                    <a href="{{route('rix_settings_email')}}" class="card-cta">Ayarları Değiştir <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-large-icons col-12 p-0">
                <div class="card-icon bg-primary text-white">
                    <i class="ion ion-social-buffer"></i>
                </div>
                <div class="card-body">
                    <h4>Önbellek</h4>
                    <p>Önbellek ile ilgi ayarlar.</p>
                    <a href="{{route('rix_settings_cache')}}" class="card-cta">Ayarları Değiştir <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-large-icons col-12 p-0">
                <div class="card-icon bg-primary text-white">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="card-body">
                    <h4>Güvenlik</h4>
                    <p>Recaptcha doğrulama.</p>
                    <a href="{{route('rix_settings_security')}}" class="card-cta">Ayarları Değiştir <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-large-icons col-12 p-0">
                <div class="card-icon bg-primary text-white">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-body">
                    <h4>Klavuz</h4>
                    <p>Yönetim panelini daha iyi kullanabilmek için gerekli bilgiler.</p>
                    <a href="{{route('rix_settings_guide')}}" class="card-cta">Görüntüle <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection

