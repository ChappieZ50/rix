<div class="card">
    <div class="d-flex justify-content-start align-items-start p-3">
        <select class="form-control" name="action" style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
            <option value="0">Seçilene Uygula</option>
            <option value="delete">Sil</option>
        </select>
        <button class="btn btn-sm btn-primary ml-1" style="box-shadow: none;border-radius: 0;" type="submit">Uygula</button>
    </div>
    <div class="card-header">
        <h4>Kategoriler</h4>
        <div class="card-header-form">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Kategori Ara...">
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @include('rix.layouts.components.posts.categories.table')
    </div>
</div>
