@extends("rix.layouts.master")

@section('page_title','Yeni Ekle')

@section('title','Yeni Ekle - Rix Admin')

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
