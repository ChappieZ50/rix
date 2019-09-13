@extends('layouts.master')

@section('content')
    <!-- start banner Area -->
    @component('layouts.components.banner-area')
        @slot('image','/img/header-bg.jpg')
        @slot('text','Hakkımızda')
        @slot('route')
            <a href="{{route('view.home')}}">Anasayfa </a> <span class="lnr lnr-arrow-right"></span> <a href="{{route('view.about')}}">Hakkımızda</a>
        @endslot
    @endcomponent
    <!-- End banner Area -->

    <!-- Start about Area -->
    <section class="home-about-area section-gap aboutus-about" id="about">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="ol-md-12 home-about-left">
                    <h6>Brand new app to blow your mind</h6>
                    <h1>
                        We’ve made a life <br>
                        that will change you
                    </h1>
                    <p class="sub">We are here to listen from you deliver exellence</p>
                    <p class="pb-20">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temp or incididunt ut labore et dolore magna aliqua. Ut enim ad minim. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End about Area -->
@endsection