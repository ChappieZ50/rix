@extends('layouts.master')

@section('content')
    <!-- start banner Area -->
    @component('layouts.components.banner-area')
        @slot('image','/img/header-bg.jpg')
        @slot('text','Keşif')
        @slot('route')
            <a href="{{route('view.home')}}">Anasayfa </a>  <span class="lnr lnr-arrow-right"></span>  <a href="{{route('view.discovery')}}"> Keşif</a>
        @endslot
    @endcomponent
    <!-- Start .... Area -->
    <section class="contact-page-area section-gap">
        <div class="container">
            <div class="row">
                
            </div>
        </div>
    </section>
    <!-- End ... Area -->
@endsection