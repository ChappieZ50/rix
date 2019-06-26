<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Başlık</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" id="txt_src" name="title" @isset($page) value="{{$page->title}}" @endisset>
        <div class="invalid-feedback" data-name="title"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Slug</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" id="txt_trg" name="slug" @isset($page) value="{{$page->slug}}" @endisset>
        <div class="invalid-feedback" data-name="slug"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">İçerik</label>
    <div class="col-sm-12 col-md-7">
        <textarea class="summernote" id="summernote">@isset($page) {!! json_decode($page->content) !!} @endisset</textarea>
        <div class="invalid-feedback d-block" data-name="content" style="margin-top: -20px;margin-bottom: 10px;"></div>
    </div>
</div>
@section('js')
    <script src="/rix/assets/js/custom.js"></script>
    <script type="text/javascript">
        $('#txt_src').on('keyup', function () {
            $('#txt_trg').val(stringToSlug($(this).val()));
            $('#txt_trg_seo').val($(this).val())
        });
    </script>
@append
