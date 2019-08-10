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
        <a href="{{route('rix_settings')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@section('content')
    @include('rix.layouts.components.status-message')
    <div class="row">

    </div>
@endsection