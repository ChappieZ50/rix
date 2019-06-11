<div class="table-responsive" id="comments">
    <table class="table table-striped" style="margin-top: 20px !important;margin-bottom: 0;">
        <tr>
            <th style="width: 10%;">
                <div class="custom-checkbox custom-control text-center">
                    <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input" id="checkbox-records">
                    <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
                </div>
            </th>
            <th style="width: 10%;">İsim</th>
            <th style="width: 40%;">Mesaj</th>
            <th style="width: 11%;">Oluşturma Tarihi</th>
            <th style="width: 6%;"><i class="fas fa-comment-alt" style="font-size: 20px;"></i></th>
            <th style="width: 5%;">İşlem</th>
        </tr>
        @if($comments->isNotEmpty())
            @include('rix.layouts.components.comments.table-content')
        @endif
    </table>
    <div class="pagination float-right mr-3 mt-3">{{$comments->appends($_GET)->links()}}</div>
    @if($comments->isEmpty())
        <div class="pl-3 pb-3">
            <span style="font-size: 15px;color:gray;">Yorum Bulunamadı</span>
        </div>
    @endif
</div>

@section('js')
    <script src="/rix/assets/js/page/components-table.js"></script>
    <script>
        let pending = '{{isset($typeData->pending) ? $typeData->pending : 0}}';
        if (pending > 0) {
            $('#beepMessage').addClass('beep beep-sidebar custom-beep');
        }
    </script>
@append

