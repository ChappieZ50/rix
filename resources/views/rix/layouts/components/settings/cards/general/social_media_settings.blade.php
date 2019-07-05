@php $setting = isset($setting->social_media_settings) ?  json_decode($setting->social_media_settings) : $setting @endphp
<div class="card" id="card_general_settings">
    <div class="card-header">
        <h4>Sosyal Medaya Ayarları</h4>
    </div>
    <div class="card-body">
        <div class="form-group row align-items-center">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Facebook</label>
            <div class="col-sm-12 col-md-7">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">http://facebook.com/</span>
                    </div>
                    <input type="text" class="form-control" name="facebook" placeholder="Facebook Profili" value="@isset($setting->facebook){{$setting->facebook}}@endisset">
                </div>
                <div class="invalid-feedback" data-name="facebook"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Twitter</label>
            <div class="col-sm-12 col-md-7">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">http://twitter.com/</span>
                    </div>
                    <input type="text" class="form-control" name="twitter" placeholder="Twitter Profili" value="@isset($setting->twitter){{$setting->twitter}}@endisset">
                </div>
                <div class="invalid-feedback" data-name="twitter"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Instagram</label>
            <div class="col-sm-12 col-md-7">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">http://instagram.com/</span>
                    </div>
                    <input type="text" class="form-control" name="instagram" placeholder="Instagram Profili" value="@isset($setting->instagram){{$setting->instagram}}@endisset">
                </div>
                <div class="invalid-feedback" data-name="instagram"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pinterest</label>
            <div class="col-sm-12 col-md-7">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">http://pinterest.com/</span>
                    </div>
                    <input type="text" class="form-control" name="pinterest" placeholder="Pinterest Profili" value="@isset($setting->pinterest){{$setting->pinterest}}@endisset">
                </div>
                <div class="invalid-feedback" data-name="pinterest"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Linkedin</label>
            <div class="col-sm-12 col-md-7">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">http://linkedin.com/</span>
                    </div>
                    <input type="text" class="form-control" name="linkedin" placeholder="Linkedin Profili" value="@isset($setting->linkedin){{$setting->linkedin}}@endisset">
                </div>
                <div class="invalid-feedback" data-name="linkedin"></div>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">VK</label>
            <div class="col-sm-12 col-md-7">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">http://vk.com/</span>
                    </div>
                    <input type="text" class="form-control" name="vk" placeholder="VK Profili" value="@isset($setting->vk) {{$setting->vk}} @endisset">
                </div>
                <div class="invalid-feedback" data-name="vk"></div>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke text-md-right">
            <button class="btn btn-primary" id="save">Kaydet</button>
        </div>
    </div>
</div>