@php $setting = isset($setting->general_settings) ?  json_decode($setting->general_settings) : $setting @endphp
<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Genel Ayarlar</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Yönetim Paneli Adı</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="panel_name" class="form-control" value="@isset($setting->panel_name){{$setting->panel_name}}@endisset">
                <div class="invalid-feedback" data-name="panel_name"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Yönetim Paneli Bağlantısı</label>
            <div class="col-sm-6 col-md-9">
                <input type="text" name="panel_connect" class="form-control" value="@isset($setting->panel_connect){{$setting->panel_connect}}@endisset">
                <div class="invalid-feedback" data-name="panel_connect"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Sayfa Başına Yazı Sayısı</label>
            <div class="col-sm-6 col-md-9">
                <input type="number" name="post_per_page" class="form-control" @isset($setting->post_per_page) value={{$setting->post_per_page}} @endisset>
                <div class="invalid-feedback" data-name="post_per_page"></div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-sm-6 col-md-9">
                <label>
                    <input type="hidden" value="0" name="adblock">
                    <input type="checkbox" name="adblock" class="custom-switch-input" @isset($setting->adblock){{$setting->adblock == 0 ? 'value=0' : 'value=1 checked' }} @else value="1" checked @endisset>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">Adblock Uyarısı</span>
                </label>
            </div>
            <div class="col-sm-6 col-md-9">
                <label>
                    <input type="hidden" value="0" name="cookie">
                    <input type="checkbox" name="cookie" class="custom-switch-input" @isset($setting->cookie){{$setting->cookie == 0 ? 'value=0' : 'value=1 checked' }} @else value="1" checked @endisset>
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
@section('js')
    <script>
        $('input[name=adblock],input[name=cookie]').on('change', function () {
            $(this).val($(this).is(':checked') ? 1 : 0);
        });
    </script>
@append