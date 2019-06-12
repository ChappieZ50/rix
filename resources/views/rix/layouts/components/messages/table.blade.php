<div class="table-responsive" id="messages">
    <table class="table table-striped" style="margin-top: 20px !important;">
        <tr>
            <th>
                <div class="custom-checkbox custom-control text-center">
                    <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input"
                           id="checkbox-records">
                    <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
                </div>
            </th>
            <th style="width: 10%;">İsim</th>
            <th style="width: 15%;">Konu</th>
            <th style="width: 40%;">Mesaj</th>
            <th style="width: 16%;">Oluşturma Tarihi</th>
            <th style="width: 5%;">İşlem</th>
        </tr>
        @if($messages->isNotEmpty())
            @include('rix.layouts.components.messages.table-content')
        @endif
    </table>
    <div class="pagination float-right mr-3">{{$messages->appends($_GET)->links()}}</div>
    @if($messages->isEmpty())
        <div class="pl-3 pb-3">
            <span style="font-size: 15px;color:gray;">Mesaj Bulunamadı.</span>
        </div>
    @endif
</div>

@section('js')
    <script src="/rix/assets/js/page/components-table.js"></script>
@append

