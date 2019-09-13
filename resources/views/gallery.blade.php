@extends('layouts.master')

@section('content')
    <!-- start banner Area -->
    @component('layouts.components.banner-area')
        @slot('image','/img/header-bg.jpg')
        @slot('text','Galeri')
        @slot('route')
            <a href="{{route('view.home')}}">Anasayfa </a>  <span class="lnr lnr-arrow-right"></span>  <a href="{{route('view.gallery')}}"> Galeri</a>
        @endslot
    @endcomponent
    <!-- End banner Area -->

    <!-- Start gallery Area -->
    <section class="service-area section-gap" id="service">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 pb-30 header-text text-center">
                    <h1 class="mb-10">Our Capturing Market Sectors</h1>
                    <p>
                        Who are in extremely love with eco friendly system..
                    </p>
                </div>
            </div>
            <div class="row">
                @for($i = 1; $i <= 3; $i++)
                    <div class="col-lg-4 col-sm-6">
                        <div class="single-service">
                            <div class="thumb">
                                <a href="img/s{{$i}}.jpg" class="img-gal">
                                    <img src="img/s{{$i}}.jpg" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>
    <!-- End gallery Area -->
@endsection