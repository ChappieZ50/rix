@extends("rix.layouts.master")
@section('page_title','Resimler')
@section('title','Resimler - Rix Admin')
{{--  JS --}}
@section('js')
    <script src="/rix/assets/js/endless-scroll.js"></script>
    <script src="/rix/assets/js/simple-post.js"></script>
    <script src="/rix/assets/js/page/gallery.js"></script>
@endsection
{{--  CSS --}}
@section('css')
    <link rel="stylesheet" href="/rix/assets/css/custom.css">
    <link rel="stylesheet" href="/rix/assets/modules/izitoast/dist/css/iziToast.min.css">
@endsection

@section('general_js')
    <script src="/rix/assets/modules/izitoast/dist/js/iziToast.min.js"></script>
    <script>
        $('#imageDetails').appendTo("body");
    </script>
@endsection

@section('section_header_bottom')
    <div class="section-header-items w-100">
        <div class="header-group">
            <div class="section-header-button">
                <a href="{{route('rix_new_media')}}" class="btn btn-primary">Yeni Ekle</a>
            </div>
        </div>
      <div class="header-group">
          <div class="bulk-select-group" style="display: none;">
              <button type="button" class="btn btn-sm btn-outline-primary" id="dismiss">İptal</button>
              <button type="button" class="btn btn-sm btn-outline-danger" id="delete_selected">Seçilenleri Sil</button>
              <button class="btn disabled btn-sm btn-danger btn-progress" id="delete_selected_progress" style="display: none;">Progress</button>
          </div>
          <button type="button" class="btn btn-sm btn-primary" id="bulk_select">Toplu Seç</button>
      </div>
    </div>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body gallery-body">
                <div class="gallery d-flex justify-content-center flex-wrap">

                </div>
            </div>
        </div>
    </div>
    @include('rix.layouts.components.media.gallery-modal')
@endsection
