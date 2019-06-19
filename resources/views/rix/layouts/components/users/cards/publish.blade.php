<div class="post-publish w-100">
    <div class="form-group m-3 d-inline-block">
        <div class="custom-control custom-radio">
            <input type="radio" id="role1" name="role" class="custom-control-input" value="admin" {{isset($user) && $user->role === 'admin' ? 'checked' : null}}>
            <label class="custom-control-label" for="role1">Yönetici</label>
        </div>
    </div>
    <div class="form-group m-3 d-inline-block">
        <div class="custom-control custom-radio">
            <input type="radio" id="role2" name="role" class="custom-control-input" value="editor" {{isset($user) && $user->role === 'editor' ? 'checked' : null}}>
            <label class="custom-control-label" for="role2">Yazar</label>
        </div>
    </div>
    <div class="form-group m-3 d-inline-block">
        <div class="custom-control custom-radio">
            <input type="radio" id="role3" name="role" class="custom-control-input" value="user" @isset($user) {{$user->role === 'user' ? 'checked' : null}} @else checked @endisset >
            <label class="custom-control-label" for="role3">Kullanıcı</label>
        </div>
    </div>
    <div class="col-sm-12 text-center newPost">
        @if(Request::route('id'))
            <button type="submit" name="update" class="btn btn-primary" id="publish">Güncelle</button>
        @else
            <button type="submit" name="submit" class="btn btn-primary" id="publish">Kullanıcıyı Ekle</button>
        @endif
        <button type="button" class="btn disabled btn-primary btn-progress" style="display: none;">Progress</button>
    </div>
</div>
