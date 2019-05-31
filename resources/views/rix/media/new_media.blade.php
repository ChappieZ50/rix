@extends("rix.layouts.master")

@section('page_title','Yeni Ekle')

@section('title','Yeni Ekle - Rix Admin')

@section('section_header_top')
    <div class="section-header-back">
        <a href="{{route('rix_gallery')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('rix.layouts.components.media.new_media')
            </div>
        </div>
    </div>
</div>
@endsection
