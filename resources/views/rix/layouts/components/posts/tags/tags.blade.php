<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Etiketler</h4>
            </div>
            <div class="card-body">
                <div class="float-left">
                    <div class="d-flex justify-content-start align-items-start">
                        <select class="form-control" name="action" style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
                            <option value="">Seçilene Uygula</option>
                            <option value="delete">Sil</option>
                        </select>
                        <button type="button" class="btn btn-sm btn-primary ml-1" style="box-shadow: none;border-radius: 0;" id="deleteInTable">
                            Uygula
                        </button>
                    </div>
                </div>
                <div class="float-right">
                    <div class="input-group">
                        <button type="button" class="btn custom-btn-dark mr-2" style="{{Request::get('search') ? 'display: show;' : 'display: none;'}}" id="closeSearch">
                            Aramadan Çık
                        </button>
                        <input type="text" class="form-control" id="searchInTags" placeholder="Etiket Ara" value="{{Request::get('search')}}">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" id="searchTagsBtn"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="clearfix mb-3"></div>
                <div class="table-responsive tagsTable">
                    @include('rix.layouts.components.posts.tags.table')
                    <div class="pagination float-right mr-3 mt-3">{{$tags->appends($_GET)->links()}}</div>
                    @if($tags->isEmpty())
                        <div class="pl-3 pb-3">
                            <span style="font-size: 15px;color:gray;">Etiket Bulunamadı</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>