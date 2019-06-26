<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Başlık</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="title" id="txt_src" @isset($post) value="{{$post->title}}" @endisset>
        <div class="invalid-feedback" data-name="title"></div>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Slug</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="slug" id="txt_trg" @isset($post) value="{{$post->slug}}" @endisset>
        <div class="invalid-feedback" data-name="slug"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">İçerik</label>
    <div class="col-sm-12 col-md-7">
        <textarea class="summernote" id="summernote">@isset($post) {!!  json_decode($post->content) !!} @endisset</textarea>
        <div class="invalid-feedback d-block" data-name="content" style="margin-top: -20px;margin-bottom: 10px;"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Özet / Açıklama</label>
    <div class="col-sm-12 col-md-7">
        <textarea class="form-control" rows="10" name="summary" id="txt_src_summary">@isset($post) {{$post->summary}} @endisset</textarea>
        <div class="invalid-feedback" data-name="summary"></div>
    </div>
</div>
@section('js')
    <script src="/rix/assets/js/custom.js"></script>
    <script type="text/javascript">
        $('#txt_src').on('keyup', function () {
            $('#txt_trg').val(stringToSlug($(this).val()));
            $('#txt_trg_seo_title').val($(this).val());
        });
        $('#txt_src_summary').on('keyup', function () {
            $('#txt_trg_seo_description').val($(this).val());
        });
    </script>
@append
