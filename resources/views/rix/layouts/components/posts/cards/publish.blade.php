<div class="post-publish w-100">
    <div class="form-group m-3 d-inline-block">
        <label>
            <input type="checkbox" name="status" class="custom-switch-input" checked value="1">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">Durum</span>
        </label>
    </div>
    <div class="form-group m-3 d-inline-block">
        <label>
            <input type="checkbox" name="featured" class="custom-switch-input" value="0">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">Öne Çıkart</span>
        </label>
    </div>
    <div class="form-group m-3 d-inline-block">
        <label>
            <input type="checkbox" name="slider" class="custom-switch-input" value="0">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">Slider'a Ekle</span>
        </label>
    </div>
    <div class="col-sm-12 text-center newPost">
        <button type="submit" name="submit" class="btn btn-primary" id="publish">Yazıyı Ekle</button>
        <button type="button" class="btn disabled btn-primary btn-progress" style="display: none;">Progress</button>
    </div>
</div>
@section('js')
    <script>
        $('input[name=status],input[name=featured],input[name=slider]').on('change', function () {
            $(this).val($(this).is(':checked') ? 1 : 0);
        });
    </script>
@append
