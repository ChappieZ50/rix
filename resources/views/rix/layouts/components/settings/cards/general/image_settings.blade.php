<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Görsel Ayarlar</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Site Logo</label>
            <div class="col-sm-6 col-md-9">
                <div class="custom-file">
                    <input type="file" name="site_logo" class="custom-file-input" id="site_logo" style="cursor:pointer;" onchange="$('#site_logo_preview').html($(this).val())">
                    <label class="custom-file-label" id="site_logo_preview">Logo Seç</label>
                </div>
            </div>
            <div class="ml-auto mr-2 mt-2">
                <img src="http://ucretsizsite.net/uploads/logo/logo_5d14d93ced227.jpg" alt="" style="max-width: 200px;">
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="form-control-label col-sm-3 text-md-right">Site Favicon</label>
            <div class="col-sm-6 col-md-9">
                <div class="custom-file">
                    <input type="file" name="site_favicon" class="custom-file-input" id="site_favicon" style="cursor:pointer;"
                           onchange="$('#site_favicon_preview').html($(this).val())">
                    <label class="custom-file-label" id="site_favicon_preview">Favicon Seç</label>
                </div>
            </div>
            <div class="ml-auto mr-2 mt-2">
                <img src="http://ucretsizsite.net/uploads/logo/logo_5d14d93ced227.jpg" alt="" style="max-width: 200px;">
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary" id="save">Kaydet</button>
        </div>
    </div>
</div>