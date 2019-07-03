<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Email Ayarları</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Güvelik Türü</label>
            <div class="col-sm-6 col-md-9">
                <select class="form-control" name="security_type">
                    <option value="tls" selected>TLS</option>
                    <option value="ssl">SSL</option>
                </select>
                <div class="invalid-feedback" data-name="security_type"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Başlık</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="email_title" class="form-control">
                <div class="invalid-feedback" data-name="email_title"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">E-Posta Sunucusu</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="email_host" class="form-control">
                <div class="invalid-feedback" data-name="email_host"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Port</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="email_port" class="form-control">
                <div class="invalid-feedback" data-name="email_port"></div>
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
            <label class="form-control-label col-sm-3 text-md-right">Şifre</label>
            <div class="col-sm-6 col-md-9">
                <input type="password" name="email_password" class="form-control">
                <div class="invalid-feedback" data-name="email_password"></div>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary" id="save">Kaydet</button>
        </div>
    </div>
</div>