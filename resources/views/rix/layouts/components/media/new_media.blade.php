<form class="dropzone" id="dropzone" method="post" enctype="multipart/form-data" action="{{route('rix_new_media')}}">
    @csrf
    <div class="fallback">
        <input name="file" type="file" multiple/>
    </div>
</form>

{{--  JS --}}
@section('js')
    <script> var route = "{{route('rix_new_media')}}"; </script>
    <script src="/rix/assets/js/page/components-multiple-upload.js"></script>
@append

{{--  General JS --}}
@section('general_js')
    <script src="/rix/assets/modules/dropzone/dist/min/dropzone.min.js"></script>
@append

{{--  General CSS --}}
@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/dropzone/dist/min/dropzone.min.css">
@append
