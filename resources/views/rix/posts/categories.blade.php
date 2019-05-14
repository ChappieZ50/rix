@extends('rix.layouts.master')

@section('page_title','Kategoriler')

@section('title','Kategoriler - Rix Admin')

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection

@section('general_js')
    <script>
        $('#parentCategoriesContent').appendTo('body');
    </script>
@endsection

@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/page/components-table.js"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-12">
            @include('rix.layouts.components.posts.categories.new')
        </div>
        <div class="col-xl-8 col-lg-12">
            @include('rix.layouts.components.posts.categories.categories')
        </div>
    </div>
@endsection
