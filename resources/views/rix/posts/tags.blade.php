@extends('rix.layouts.master')

@section('page_title','Etiketler')

@section('title','Etiketler - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('js')
    <script src="/rix/assets/js/page/components-table.js"></script>
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-12">
            @include('rix.layouts.components.posts.tags.new')
        </div>
        <div class="col-xl-8 col-lg-12">
            @include('rix.layouts.components.posts.tags.tags')
        </div>
    </div>
@endsection

