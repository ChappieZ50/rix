<div class="card">
    <div class="d-flex justify-content-start align-items-start p-3">
        <select class="form-control" name="action" data-area="#categories" style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
            <option>Seçilene Uygula</option>
            <option value="delete">Sil</option>
        </select>
        <button type="button" class="btn btn-sm btn-primary ml-1" style="box-shadow: none;border-radius: 0;" id="deleteInTable">Uygula</button>
    </div>
    <div class="card-header">
        <h4>Kategoriler</h4>
        <div class="card-header-form">
            <div class="input-group">
                <button type="button" class="btn custom-btn-dark mr-2" style="display: none;" id="closeSearch">Aramadan Çık</button>
                <input type="text" class="form-control" id="searchInCategories" placeholder="Kategori Ara...">
                <div class="input-group-btn">
                    <button class="btn btn-primary"  id="searchCategoriesBtn" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0" id="categoriesTable">
        @include('rix.layouts.components.posts.categories.table')
    </div>
</div>
<div id="parentCategoriesContent"></div>
