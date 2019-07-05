@php $setting = isset($setting->setting) ?  json_decode($setting->setting) : $setting @endphp
<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Ayarlar</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">E-Posta</label>
            <div class="col-sm-6 col-md-9">
                <input type="email" name="email" class="form-control" value="@isset($setting->email){{$setting->email}}@endisset">
                <div class="invalid-feedback" data-name="email"></div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-sm-6 col-md-9">
                <label>
                    <input type="hidden" value="0" name="status_send_email">
                    <input type="checkbox" name="status_send_email" class="custom-switch-input" @isset($setting->status_send_email){{$setting->status_send_email == 0 ? 'value=0' : 'value=1 checked' }} @else value="1" checked @endisset>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">İletişim mesajlarını e-posta adresine gönder</span>
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
        $('input[name=status_send_email]').on('change', function () {
            $(this).val($(this).is(':checked') ? 1 : 0);
        });
    </script>
@append