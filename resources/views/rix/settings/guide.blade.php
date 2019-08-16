@extends('rix.layouts.master')

@section('page_title','Klavuz')

@section('title','Klavuz - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('section_header_top')
    <div class="section-header-back">
        <a href="{{route('rix.settings.setting')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Anasayfa</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                        Son gönderilen <span class="text-title">Mesaj, Yorum ve Üye Olan Kullanıcılar</span> görüntülenmektedir.
                        Anasayfada tamamen önbelleklenmiştir (cache) ve 10 dakika süresi vardır yani bir veri girildiğinde siz eğer önbelleği sıfırlamazsanız anasayfaya ilk
                        girişinizde
                        veriniz gözükür fakat 2. bir veri ekleyip anasayfayı yenilediğinizde gözükmez. 10 dakika arayla yeni verileri görebilirsiniz veya <a
                                href="{{route('rix.settings.cache')}}" target="_blank"> Önbellek</a> sayfasından sıfırlayabilirsiniz.
                        <br><br>
                        <span class="text-title">Toplam Yazı,Yorum,Kullanıcı ve Abone</span> bölümlerinde toplam kaç veri var görebilirsiniz. Bu bölümdede önbellek olayı
                        geçerlidir.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Galeri</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        -
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Yazılar</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse3" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse3">
                    <div class="card-body">
                        -
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Kategoriler</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse4" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse4">
                    <div class="card-body">
                        -
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Etiketler</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse5" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse5">
                    <div class="card-body">
                        -
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Sayfalar</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse6" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse6">
                    <div class="card-body">
                        -
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Yorumlar</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse7" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse7">
                    <div class="card-body">
                        -
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Mesajlar</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse8" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse8">
                    <div class="card-body">
                        -
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Aboneler</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse9" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse9">
                    <div class="card-body">
                        Abonelere mail göndermeden önce <a href="{{route('rix.settings.email')}}" target="_blank">tıklayınız</a>. E-Posta ayarları sayfasından gerekli bilgileri
                        girdikten sonra eğer vds veya vps sunucunuz varsa terminal ekranından <span class="text-title">php artisan work:queue --queue=mail --tries=2</span> kodunu
                        çalıştırarak kuyruktaki işlemleri başlatabilirsiniz. Eğer bir hosting üzerinden çalışıyorsanız <a href="{{route('rix.settings.setting')}}" target="_blank">Ayarlar
                            sayfasındaki</a> <span class="text-title">"Dikkat"</span> bölümünde ne yapacağınızı anlattım. Şimdi abone mail gönderme işlemine başlayabilirisiniz.
                        Gönder butonuna tıklamadan önce
                        mutlaka önizleme yapınız. Göndere bastıktan sonra işlem
                        kuyruğa alınacaktır ve her 5 saniyede bir aboneye mail gönderecektir. İşlem tamamlandığında bilgirim alacaksınız.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Ayarlar</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse10" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse10">
                    <div class="card-body">
                       -
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection