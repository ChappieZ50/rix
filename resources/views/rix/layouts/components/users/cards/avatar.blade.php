<div class="select-image w-100">
    <div class="image-preview mx-auto d-flex justify-content-center align-items-center" style="height:50px; background:#edeff0;width:100%">
        <label class="btn" style="background:transparent;padding-bottom:50px !important;width: 100%;height: 100%;" for="avatar">Avatar Seç</label>
        <input type="file" id="avatar" name="avatar" style="display: none">
    </div>
    <div id="image-preview" class="mx-auto d-flex justify-content-center align-items-center" style="display: block;">
        <img src="@if(isset($user) && !empty($user->avatar)) {{url(asset('storage/avatars').'/'.$user->avatar)}}  @endif" id="preview_selected_image" class="rounded-circle"
             style="@if(isset($user) && !empty($user->avatar)) display: block @else display:none; @endif ;height: 120px;width: 120px;">
    </div>
    <div class="invalid-feedback" data-name="avatar"></div>
</div>

@section('js')
    <script>
        previewImage($('#preview_selected_image'));
    </script>
@append