<div class="card newTag">
    <div class="d-flex justify-content-start align-items-start p-3">
        <select class="form-control" name="action" style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
            <option value="0">Seçilene Uygula</option>
            <option value="delete">Sil</option>
        </select>
        <button class="btn btn-sm btn-primary ml-1" style="box-shadow: none;border-radius: 0;" id="deleteInTable" type="button">Uygula</button>
    </div>
    <div class="card-header">
        <h4>Etiketler</h4>
        <div class="card-header-form">
            <div class="input-group">
                <button type="button" class="btn custom-btn-dark mr-2" style="display: none;" id="closeSearch">Aramadan Çık</button>
                <input type="text" class="form-control" id="searchInTags" placeholder="Etiket Ara...">
                <div class="input-group-btn">
                    <button class="btn btn-primary" id="searchTagsBtn" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0" id="tagsTable">
        @include('rix.layouts.components.posts.tags.table')
    </div>
</div>
