<div class="card newTag">
    <div class="card-header">
        @if($editTag)
            <div class="section-header-back">
                <a href="{{route('rix.tags')}}" class="btn btn-icon ml-0" style="border-radius: 3px;padding:3px 15px;"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h4><span>{{!isset($editTag) ?: $editTag->name}}</span> | Düzenleniyor</h4>
        @else
            <h4>Etiket Ekle</h4>
        @endif
    </div>
    <div class="card-body">
        <div class="form-group">
            <label>İsim</label>
            <input type="text" class="form-control" name="name" id="txt_src" value="{{\App\Helpers\Helper::write($editTag,'name')}}">
            <div class="invalid-feedback" data-name="name"></div>
        </div>
        <div class="form-group">
            <label>Slug</label>
            <input type="text" class="form-control" id="txt_trg" name="slug" value="{{\App\Helpers\Helper::write($editTag,'name')}}">
            <div class="invalid-feedback" data-name="slug"></div>
        </div>
        @if($editTag)
            <button class="btn btn-primary" type="button" id="update" onclick="updateTag({{\App\Helpers\Helper::write($editTag,'term_id')}})">Güncelle</button>
        @else
            <button class="btn btn-primary" type="button" id="publish">Etiketi Ekle</button>
        @endif
        <button type="button" class="btn disabled btn-primary btn-progress" style="display: none;">Progress</button>
    </div>
</div>
@section('js')
    <script src="/rix/assets/js/custom.js"></script>
    <script src="/rix/assets/js/page/tags.js"></script>
@append
