@extends("rix.layouts.master")
@section('page_title','Resimler')
@section('title','Resimler - Rix Admin')
{{--  JS --}}
@section('js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="/rix/assets/js/page/gallery-paginate.js"></script>
    <script src="/rix/assets/js/fixed-section-header.js"></script>
    <script src="/rix/assets/js/custom.js"></script>
    <script>
        let _paginateProgress = $('.progress-gallery a');
        let _paginateContent = $('.gallery-content');
        galleryPaginate({
            progress:_paginateProgress,
            content:_paginateContent,
        });
    </script>
@endsection
{{--  CSS --}}
@section('css')
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
@endsection
@section('section_header')
    <div class="float-right">
        <button type="button" class="btn btn-danger delete_selected">
            Seçilenleri Sil <span class="badge badge-transparent">0</span>
        </button>
    </div>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="gallery">
                    @if(!empty($images->toArray()['data']))
                        <form action="{{route('rix_delete_image')}}" method="post">
                            <div class="form-group">
                                <div class="row gutters-sm gallery-content d-flex justify-content-start">
                                    @include('rix.layouts.components.media.images')
                                </div>
                                <div class="progress-gallery d-flex justify-content-center">
                                    <a href="javascript:;" class="btn disabled btn-primary btn-progress" style="width: 150px;">Progress</a>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="text-center">
                            <h4>Henüz resim eklenmemiş.</h4>
                        </div>
                        @include('rix.layouts.components.media.new_media')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
