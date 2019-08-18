<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kullanıcı Adı</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="username" @isset($user) value="{{$user->username}}" @endisset>
        <div class="invalid-feedback" data-name="username">asd</div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Ad Soyad</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="name" @isset($user) value="{{$user->name}}" @endisset>
        <div class="invalid-feedback" data-name="name"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">E-Posta</label>
    <div class="col-sm-12 col-md-7">
        <input type="email" class="form-control" name="email" @isset($user) value="{{$user->email}}" @endisset>
        <div class="invalid-feedback" data-name="email"></div>
    </div>
</div>
@php
    $social = isset($user) ? json_decode($user->user_data ) : [];
@endphp

<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Biyografi</label>
    <div class="col-sm-12 col-md-7">
        <textarea class="form-control" name="biography">@if(isset($user) && !empty($social)){{$social->biography}} @endif</textarea>
        <div class="invalid-feedback" data-name="biography"></div>
    </div>
</div>

<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Web Sitesi</label>
    <div class="col-sm-12 col-md-7">
        <input type="url" class="form-control" name="web" value="@if(isset($user) && !empty($social)){{$social->web}} @endif">
        <div class="invalid-feedback" data-name="web"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Facebook</label>
    <div class="col-sm-12 col-md-7">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">http://facebook.com/</span>
            </div>
            <input type="text" class="form-control" name="facebook" @if(isset($user) && !empty($social)) value="{{$social->facebook->name}}" @endif>
        </div>
        <div class="invalid-feedback" data-name="facebook"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Twitter</label>
    <div class="col-sm-12 col-md-7">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">http://twitter.com/</span>
            </div>
            <input type="text" class="form-control" name="twitter" @if(isset($user) && !empty($social)) value="{{$social->twitter->name}}" @endif>
        </div>
        <div class="invalid-feedback" data-name="twitter"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Instagram</label>
    <div class="col-sm-12 col-md-7">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">http://instagram.com/</span>
            </div>
            <input type="text" class="form-control" name="instagram" @if(isset($user) && !empty($social)) value="{{$social->instagram->name}}" @endif>
        </div>
        <div class="invalid-feedback" data-name="instagram"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Youtube</label>
    <div class="col-sm-12 col-md-7">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">http://youtube.com/</span>
            </div>
            <input type="text" class="form-control" name="youtube" @if(isset($user) && !empty($social)) value="{{$social->youtube->name}}" @endif>
        </div>
        <div class="invalid-feedback" data-name="youtube"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Linkedin</label>
    <div class="col-sm-12 col-md-7">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">http://linkedin.com/</span>
            </div>
            <input type="text" class="form-control" name="linkedin" @if(isset($user) && !empty($social)) value="{{$social->linkedin->name}}" @endif>
        </div>
        <div class="invalid-feedback" data-name="linkedin"></div>
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pinterest</label>
    <div class="col-sm-12 col-md-7">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">http://pinterest.com/</span>
            </div>
            <input type="text" class="form-control" name="pinterest" @if(isset($user) && !empty($social)) value="{{$social->pinterest->name}}" @endif>
        </div>
        <div class="invalid-feedback" data-name="pinterest"></div>
    </div>
</div>
<div class="password_area">
    @isset($user)
        <div class="form-group row mb-2">
            <div class="offset-md-3 offset-lg-3 offset-12"></div>
            <div class="col-sm-12 col-md-7">
                <button class="btn btn-outline-primary" type="button" id="resetPassword" data-auth="{{Auth::user()->user_id === $user->user_id ? 'self' : 'other'}}">Şifreyi
                    Sıfırla
                </button>
            </div>
        </div>
    @else
        <div class="form-group row mb-2">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Şifre</label>
            <div class="col-sm-12 col-md-7">
                <input type="password" class="form-control" name="password">
                <div class="invalid-feedback" data-name="password"></div>
            </div>
        </div>
        <div class="form-group row mb-2">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Şifre Tekrar</label>
            <div class="col-sm-12 col-md-7">
                <input type="password" class="form-control" name="password_confirmation">
                <div class="invalid-feedback" data-name="password_confirmation"></div>
            </div>
        </div>
    @endisset
</div>
@section('js')
    <script src="/rix/assets/js/custom.js"></script>
@append
