@php $setting = isset($setting->cache) ?  json_decode($setting->cache) : $setting @endphp
<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Önbellek Ayarları</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <div class="row align-items-center justify-content-center">
                <div class="col-sm-6 col-md-10">
                    <label>
                        <input type="hidden" value="0" name="status_cache">
                        <input type="checkbox" name="status_cache" class="custom-switch-input"
                               @isset($setting->status_cache){{$setting->status_cache == 0 ? 'value=0' : 'value=1 checked' }} @else value="1" checked @endisset>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Önbelleklemeyi Etkinleştir</span>
                    </label>
                </div>
                <div class="col-sm-6 col-md-10">
                    <label>
                        <input type="hidden" value="0" name="status_cache_refresh">
                        <input type="checkbox" name="status_cache_refresh" class="custom-switch-input"
                               @isset($setting->status_cache_refresh){{$setting->status_cache_refresh == 0 ? 'value=0' : 'value=1 checked' }} @else value="1" checked @endisset>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Otomatik Yenileme (Yazı,sayfa vb şeyler eklendiğinde otomatik olarak yenilenir)</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Önbellek Yenilenme Zamanı (dakika)</label>
            <div class="col-sm-6 col-md-9">
                <input type="number" class="form-control" name="cache_refresh_time"
                       placeholder="Varsayılan süre 30 dakika" @isset($setting->cache_refresh_time) value={{$setting->cache_refresh_time}} @endisset>
                <div class="invalid-feedback" data-name="cache_refresh_time"></div>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary" id="save">Kaydet</button>
            <button class="btn btn-warning" id="refreshCache">Önbelleği Sıfırla</button>
        </div>
    </div>
</div>
@section('js')
    <script>
        $('input[name=status_cache],input[status_cache_refresh]').on('change', function () {
            $(this).val($(this).is(':checked') ? 1 : 0);
        });
    </script>
@append