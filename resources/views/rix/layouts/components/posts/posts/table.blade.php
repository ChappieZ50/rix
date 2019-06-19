<table class="table table-striped" id="posts">
    <tr>
        <th>
            <div class="custom-checkbox custom-control text-center">
                <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input"
                       id="checkbox-records">
                <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
            </div>
        </th>
        <th>Başlık</th>
        <th>Kategoriler</th>
        <th>Etiketler</th>
        <th>Oluşturma Tarihi</th>
        <th><i class="fas fa-comment-alt" style="font-size: 20px;"></i></th>
    </tr>
    @if($posts->isNotEmpty())
        @include('rix.layouts.components.posts.posts.table-content')
    @endif
</table>
@section('js')
    <script src="/rix//assets/js/page/features-posts.js"></script>
    <script src="/rix//assets/js/page/components-table.js"></script>
@append