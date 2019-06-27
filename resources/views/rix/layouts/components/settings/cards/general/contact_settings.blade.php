<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>İletişim Ayarları</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Adres</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="address" class="form-control">
                <div class="invalid-feedback" data-name="address"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">E-Posta</label>
            <div class="col-sm-6 col-md-9">
                <input type="email" name="email" class="form-control">
                <div class="invalid-feedback" data-name="email"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Telefon</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="phone" class="form-control">
                <div class="invalid-feedback" data-name="phone"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">İletişim Metni</label>
            <div class="col-sm-6 col-md-9">
                <textarea class="summernote-simple" name="contact_text"></textarea>
                <div class="invalid-feedback" data-name="contact_text"></div>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary" id="save">Kaydet</button>
        </div>
    </div>
</div>

@section('general_js')
    <script src="/rix/assets/modules/summernote/dist/summernote-bs4.js"></script>
@append

@section('general_css')
    <link rel="stylesheet" href="/rix/assets/modules/summernote/dist/summernote-bs4.css">
@append