<div class="card">
    <div class="card-header">
        @if($editItem)
            <div class="section-header-back">
                <a href="{{route('rix_categories')}}" class="btn btn-icon ml-0" style="border-radius: 3px;padding:3px 15px;"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h4>{{\App\Helpers\Helper::write($editItem,'name')}} | Düzenleniyor</h4>
        @else
            <h4>Kategori Ekle</h4>
        @endif
    </div>
    <div class="card-body newCategory">
        <div class="form-group">
            <label>İsim</label>
            <input type="text" class="form-control" name="name" id="txt_src" value="{{\App\Helpers\Helper::write($editItem,'name')}}">
            <div class="invalid-feedback" data-name="name"></div>
        </div>
        <div class="form-group">
            <label>Slug</label>
            <input type="text" class="form-control" id="txt_trg" name="slug" value="{{\App\Helpers\Helper::write($editItem,'slug')}}">
            <div class="invalid-feedback" data-name="slug"></div>
        </div>
        <div class="form-group">
            <label>Alt Kategorisi</label>
            <select class="form-control" name="parent_category">
                <option value="0">Yok</option>
                @include('rix.layouts.components.posts.categories.parents')
            </select>
            <div class="invalid-feedback" data-name="parent_category"></div>
        </div>
        @if($editItem)
            <button class="btn btn-primary" type="button" id="update" onclick="update({{\App\Helpers\Helper::write($editItem,'term_id')}})">Güncelle</button>
        @else
            <button class="btn btn-primary" type="button" id="publish">Kategoriyi Ekle</button>
        @endif
        <button type="button" class="btn disabled btn-primary btn-progress" style="display: none;">Progress</button>

    </div>
</div>

@section('js')
    <script src="/rix/assets/js/custom.js"></script>
    <script src="/rix/assets/js/simple-post.js"></script>
    <script src="/rix/assets/js/page/categories.js"></script>
@append
