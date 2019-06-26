<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Başlık</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control input-title" name="seo_title" id="txt_trg_seo" @isset($page) value="{{$page->seo_title}}" @endisset>
        <div class="invalid-feedback" data-name="seo_title"></div>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Açıklama</label>
    <div class="col-sm-12 col-md-7">
        <textarea class="form-control" name="seo_description">@isset($page) {{$page->seo_description}} @endisset</textarea>
        <div class="invalid-feedback" data-name="seo_description"></div>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Anahtar Kelimeler</label>
    <div class="col-sm-12 col-md-7">
        <input type="text"  name="seo_keywords" @isset($page) value="{{$page->seo_keywords}}" @endisset>
        <div class="invalid-feedback" data-name="seo_keywords"></div>
        <p>Not:
            <small>Google artık anahtar kelimeleri görmüyor.</small>
        </p>
    </div>
</div>
@section('js')
    <script>
        let keywords = document.querySelector('input[name=seo_keywords]');
        new Tagify(keywords);
    </script>
@append