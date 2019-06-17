<table class="table table-striped" id="subscriptions">
    <tr>
        <th>
            <div class="custom-checkbox custom-control text-center">
                <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input"
                       id="checkbox-records">
                <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
            </div>
        </th>
        <th>E-Posta</th>
        <th>İp Adresi</th>
        <th>Oluşturma Tarihi</th>
    </tr>
    @if($subscriptions->isNotEmpty())
        @include('rix.layouts.components.subscriptions.table-content')
    @endif
</table>

@section('js')
    <script src="/rix//assets/js/page/components-table.js"></script>
    <script src="/rix//assets/js/page/features-posts.js"></script>
@append

