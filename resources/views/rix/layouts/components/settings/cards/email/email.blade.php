@php $setting = isset($setting->email) ?  json_decode($setting->email) : $setting @endphp
<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Email Ayarları</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Güvelik Türü</label>
            <div class="col-sm-6 col-md-9">
                <select class="form-control" name="security_type">
                    <option value="tls"  @isset($setting->security_type){{$setting->security_type == 'tls' ? 'selected' : null}}@endisset>TLS</option>
                    <option value="ssl" @isset($setting->security_type){{$setting->security_type == 'ssl' ? 'selected' : null}}@endisset>SSL</option>
                </select>
                <div class="invalid-feedback" data-name="security_type"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Başlık</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="email_title" class="form-control" value="@isset($setting->email_title){{$setting->email_title}}@endisset">
                <div class="invalid-feedback" data-name="email_title"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">E-Posta Sunucusu</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="email_host" class="form-control" value="@isset($setting->email_host){{$setting->email_host}}@endisset">
                <div class="invalid-feedback" data-name="email_host"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Port</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="email_port" class="form-control" value="@isset($setting->email_port){{$setting->email_port}}@endisset">
                <div class="invalid-feedback" data-name="email_port"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">E-Posta</label>
            <div class="col-sm-6 col-md-9">
                <input type="email" name="email" class="form-control" value="@isset($setting->email){{$setting->email}}@endisset">
                <div class="invalid-feedback" data-name="email"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Şifre</label>
            <div class="col-sm-6 col-md-9">
                <input type="password" name="email_password" class="form-control" value="@isset($setting->email_password){{!empty($setting->email_password) ? '#password' : null}}@endisset">
                <p class="note text-muted text-dark"><small>Güvenlik nedeniyle şifreniz <span class="text-primary">#password</span> olarak gösterilir</small></p>
                <div class="invalid-feedback" data-name="email_password"></div>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary" id="save">Kaydet</button>
        </div>
    </div>
</div>