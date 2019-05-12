<div class="card">
    <div class="card-header">
        <h4>Kategori Ekle</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label>İsim</label>
            <input type="text" class="form-control" name="name" id="txt_src">
            <div class="invalid-feedback" data-name="name"></div>
        </div>
        <div class="form-group">
            <label>Slug</label>
            <input type="text" class="form-control" id="txt_trg" name="slug">
            <div class="invalid-feedback" data-name="slug"></div>
        </div>
        <div class="form-group">
            <label>Alt Kategorisi</label>
            <select class="form-control" name="parent_category">
                @include('rix.layouts.components.posts.categories.parents')
            </select>
            <div class="invalid-feedback" data-name="parent_category"></div>
        </div>
        <button class="btn btn-primary" id="publish">Kategoriyi Ekle</button>
        <button type="button" class="btn disabled btn-primary btn-progress" style="display: none;">Progress</button>
    </div>
</div>

@section('js')
    <script src="/rix/assets/js/custom.js"></script>
    <script src="/rix/assets/js/simple-post.js"></script>
    <script src="/rix/assets/js/page/categories.js"></script>
@append
