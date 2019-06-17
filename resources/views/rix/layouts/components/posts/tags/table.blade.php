<table class="table table-striped" id="tags">
    <tr>
        <th>
            <div class="custom-checkbox custom-control text-center">
                <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input"
                       id="checkbox-records">
                <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
            </div>
        </th>
        <th>İsim</th>
        <th>Slug</th>
        <th>Oluşturma Tarihi</th>
    </tr>
    @if($tags->isNotEmpty())
        @include('rix.layouts.components.posts.tags.table-content')
    @endif
</table>

@section('js')
    <script src="/rix//assets/js/page/components-table.js"></script>
    <script src="/rix//assets/js/page/features-posts.js"></script>
@append