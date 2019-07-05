@php $setting = isset($setting->security) ?  json_decode($setting->security) : $setting @endphp
<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Güvenlik Ayarları</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <div class="row align-items-center justify-content-center">
                <div class="col-sm-6 col-md-10">
                    <label>
                        <input type="hidden" value="0" name="status_recaptcha">
                        <input type="checkbox" name="status_recaptcha" class="custom-switch-input" @isset($setting->status_recaptcha){{$setting->status_recaptcha == 0 ? 'value=0' : 'value=1 checked' }} @endisset>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Recaptcha Etkinleştir</span>
                    </label>
                </div>
                <div class="col-sm-6 col-md-10">
                    <label>
                        <input type="hidden" value="0" name="status_recaptcha_comments">
                        <input type="checkbox" name="status_recaptcha_comments" class="custom-switch-input" @isset($setting->status_recaptcha_comments){{$setting->status_recaptcha_comments == 0 ? 'value=0' : 'value=1 checked' }} @endisset>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Recaptchayı Yorumlarda Kullan</span>
                    </label>
                </div>
                <div class="col-sm-6 col-md-10">
                    <label>
                        <input type="hidden" value="0" name="status_recaptcha_panel">
                        <input type="checkbox" name="status_recaptcha_panel" class="custom-switch-input" @isset($setting->status_recaptcha_panel){{$setting->status_recaptcha_panel == 0 ? 'value=0' : 'value=1 checked' }} @endisset>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Recaptchayı Panel Girişinde Kullan</span>
                    </label>
                </div>
                <div class="col-sm-6 col-md-10">
                    <label>
                        <input type="hidden" value="0" name="status_recaptcha_login">
                        <input type="checkbox" name="status_recaptcha_login" class="custom-switch-input" @isset($setting->status_recaptcha_login){{$setting->status_recaptcha_login == 0 ? 'value=0' : 'value=1 checked' }} @endisset>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Recaptchayı Giriş Yap / Üye Ol Alanlarında kullan</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Site Anahtarı</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" class="form-control" name="recaptcha_site_key" value="@isset($setting->recaptcha_site_key){{$setting->recaptcha_site_key}}@endisset">
                <div class="invalid-feedback" data-name="recaptcha_site_key"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Gizli Anahtar</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" class="form-control" name="recaptcha_secret_key" value="@isset($setting->recaptcha_secret_key){{$setting->recaptcha_secret_key}}@endisset">
                <div class="invalid-feedback" data-name="recaptcha_secret_key"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Dil</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" class="form-control" name="recaptcha_language" value="@isset($setting->recaptcha_language){{$setting->recaptcha_language}}@endisset">
                <div class="invalid-feedback" data-name="recaptcha_language"></div>
                <div class="note"><a href="https://developers.google.com/recaptcha/docs/language" target="_blank">Dil Kodları</a></div>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary" id="save">Kaydet</button>
        </div>
    </div>
</div>
@section('js')
    <script>
        $('input[name=status_recaptcha],input[name=status_recaptcha_comments],input[name=status_recaptcha_panel],input[name=status_recaptcha_login]').on('change', function () {
            $(this).val($(this).is(':checked') ? 1 : 0);
        });
    </script>
@append