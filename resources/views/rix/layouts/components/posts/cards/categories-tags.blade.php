<div class="w-100">
    <div class="form-group mb-3">
        <label>Kategori Seçiniz</label>
        <div class="clearfix"></div>
        <div class="select-category">
            @include('rix.layouts.components.posts.cards.categories-tags.categories-select')
        </div>
        <div class="invalid-feedback" data-name="categories"></div>
    </div>
    <div class="form-group">
        <label>Etiketler</label>
        <div class="select-tag">
            @include('rix.layouts.components.posts.cards.categories-tags.tags-select')
        </div>
        <div class="invalid-feedback" data-name="tags"></div>
    </div>
</div>
