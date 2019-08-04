@extends("rix.layouts.master")
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="ion ion-pin"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Toplam Yazı</h4>
                    </div>
                    <div class="card-body">
                        @isset($records['post']) {{$records['post']}} @endisset
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="ion ion-ios-chatbubble"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Toplam Yorum</h4>
                    </div>
                    <div class="card-body">
                        @isset($records['comment']) {{$records['comment']}} @endisset
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Toplam Kullanıcı</h4>
                    </div>
                    <div class="card-body">
                        @isset($records['user']) {{$records['user']}} @endisset
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="ion ion-speakerphone"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Toplam Abone</h4>
                    </div>
                    <div class="card-body">
                        @isset($records['subscription']) {{$records['subscription']}} @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection