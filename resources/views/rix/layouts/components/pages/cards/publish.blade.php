<div class="post-publish w-100">
    <div class="form-group m-3 d-inline-block">
        <label>
            <input type="checkbox" name="status" class="custom-switch-input" @isset($page) {{$page->status == 1 ? 'checked value="1"' : null}} @else checked value="1" @endisset>
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">Durum</span>
        </label>
    </div>
    <div class="form-group m-3 d-inline-block">
        <label>
            <input type="checkbox" name="registered" class="custom-switch-input"  @isset($page) {{$page->registered == 1 ? 'checked value="1"' : null}} @else value="0" @endisset>
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">Sadece Kayıtlı Kullanıcılara Göster</span>
        </label>
    </div>
    <div class="col-sm-12 text-center page">
        @if(Request::route('id'))
            <button type="submit" name="update" class="btn btn-primary" id="publish">Güncelle</button>
        @else
            <button type="submit" name="submit" class="btn btn-primary" id="publish">Sayfayı Ekle</button>
        @endif
        <button type="button" class="btn disabled btn-primary btn-progress" style="display: none;">Progress</button>
    </div>
</div>
@section('js')
    <script>
        $('input[name=status],input[name=registered]').on('change', function () {
            $(this).val($(this).is(':checked') ? 1 : 0);
        });
    </script>
@append