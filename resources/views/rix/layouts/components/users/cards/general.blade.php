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
<div class="password_area">
    @isset($user)
        <div class="form-group row mb-2">
            <div class="offset-md-3 offset-lg-3 offset-12"></div>
            <div class="col-sm-12 col-md-7">
                <button class="btn btn-outline-primary" type="button" id="resetPassword" data-auth="other">Şifreyi Sıfırla</button>
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
