@php $setting = isset($setting->seo) ?  json_decode($setting->seo) : $setting @endphp
<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Seo Ayarları</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Site Adı</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="site_name" class="form-control" value="@isset($setting->site_name){{$setting->site_name}}@endisset">
                <div class="invalid-feedback" data-name="site_name"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Site Açıklaması</label>
            <div class="col-sm-6 col-md-9">
                <textarea name="site_description" class="form-control">@isset($setting->site_description){{$setting->site_description}}@endisset</textarea>
                <div class="invalid-feedback" data-name="site_description"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Anasayfa Adı</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="homepage_name" class="form-control" value="@isset($setting->homepage_name){{$setting->homepage_name}}@endisset">
                <div class="invalid-feedback" data-name="homepage_name"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Anahtar Kelimeler</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="keywords" value="@isset($setting->keywords){{$setting->keywords}}@endisset">
                <div class="invalid-feedback" data-name="keywords"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">HTML Head Kodu</label>
            <div class="col-sm-6 col-md-9">
                <textarea name="site_html_head" class="form-control codeeditor">@isset($setting->site_html_head){{$setting->site_html_head}}@endisset</textarea>
                <div class="invalid-feedback" data-name="site_html_head"></div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-sm-6 col-md-9">
                <label>
                    <input type="hidden" value="0" name="status_site_name">
                    <input type="checkbox" name="status_site_name" class="custom-switch-input"
                           @isset($setting->status_site_name){{$setting->status_site_name == 0 ? 'value=0' : 'value=1 checked' }} @else value="1" checked @endisset>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">Site Adını Göster</span>
                </label>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary" id="save">Kaydet</button>
        </div>
    </div>
</div>
@section('general_js')
    <script src="/rix/assets/js/tagify.min.js"></script>
    <script src="/rix/assets/modules/codemirror/lib/codemirror.js"></script>
@append

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/css/tagify.css">
    <link rel="stylesheet" href="/rix/assets/modules/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="/rix/assets/modules/codemirror/theme/duotone-dark.css">
@append

@section('js')
    <script>
        let keywords = document.querySelector('input[name=keywords]');
        new Tagify(keywords);
        $('input[name=status_site_name]').on('change', function () {
            $(this).val($(this).is(':checked') ? 1 : 0);
        });
    </script>
@append