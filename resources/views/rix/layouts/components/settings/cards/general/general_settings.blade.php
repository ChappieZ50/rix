<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Genel Ayarlar</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Yönetim Paneli Adı</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="panel_name" class="form-control">
                <div class="invalid-feedback" data-name="panel_name"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Yönetim Paneli Bağlantısı</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="panel_connect" class="form-control">
                <div class="invalid-feedback" data-name="panel_connect"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Sayfa Başına Yazı Sayısı</label>
            <div class="col-sm-6 col-md-9">
                <input type="number" name="post_per_page" class="form-control">
                <div class="invalid-feedback" data-name="post_per_page"></div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-sm-6 col-md-9">
                <label>
                    <input type="hidden" value="0" name="adblock">
                    <input type="checkbox" name="adblock" class="custom-switch-input" checked value="1">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">Adblock Uyarısı</span>
                </label>
            </div>
            <div class="col-sm-6 col-md-9">
                <label>
                    <input type="hidden" value="0" name="cookie">
                    <input type="checkbox" name="cookie" class="custom-switch-input" checked value="1">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">Çerez Uyarısı</span>
                </label>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary" id="save">Kaydet</button>
        </div>
    </div>
</div>