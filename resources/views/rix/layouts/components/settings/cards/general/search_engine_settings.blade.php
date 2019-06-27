<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Arama Motoru Ayarları</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Google Doğrulama Kodu</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="google_verify" class="form-control">
                <div class="invalid-feedback" data-name="google_verify"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Bing Doğrulama Kodu</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="bing_verify" class="form-control">
                <div class="invalid-feedback" data-name="bing_verify"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Yandex Doğrulama Kodu</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="yandex_verify" class="form-control">
                <div class="invalid-feedback" data-name="yandex_verify"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">One Signal Doğrulama Kodu</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="one_signal_verify" class="form-control">
                <div class="invalid-feedback" data-name="one_signal_verify"></div>
            </div>
        </div>
        <div class="form-group row">
            <label class="form-control-label col-sm-3 text-md-right">Google Analitik Kodu</label>
            <div class="col-sm-6 col-md-9">
                <textarea class="form-control codeeditor" name="google_analytics_code"></textarea>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary" id="save">Kaydet</button>
        </div>
    </div>
</div>
@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="/rix/assets/modules/codemirror/theme/duotone-dark.css">
@append

@section('general_js')
    <script src="/rix/assets/modules/codemirror/lib/codemirror.js"></script>
@append