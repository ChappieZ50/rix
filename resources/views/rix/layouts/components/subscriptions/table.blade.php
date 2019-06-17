<div class="table-responsive" id="subscriptions">
    <table class="table table-striped" style="margin-top: 20px !important;margin-bottom: 0;">
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
            <th>İşlem</th>
        </tr>
        @if($subscriptions->isNotEmpty())
            @include('rix.layouts.components.subscriptions.table-content')
        @endif
    </table>
    <div class="pagination float-right mr-3 mt-3">{{$subscriptions->appends($_GET)->links()}}</div>
    @if($subscriptions->isEmpty())
        <div class="pl-3 pb-3">
            <span style="font-size: 15px;color:gray;">Abonelik Bulunamadı</span>
        </div>
    @endif
</div>

@section('js')
    <script src="/rix/assets/js/page/components-table.js"></script>
@append

