<table class="table table-striped" id="comments">
    <tr>
        <th>
            <div class="custom-checkbox custom-control text-center">
                <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input"
                       id="checkbox-records">
                <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
            </div>
        </th>
        <th>İsim</th>
        <th>E-Posta</th>
        <th style="width: 40%;">Mesaj</th>
        <th>Oluşturma Tarihi</th>
        <th><i class="fas fa-comment-alt" style="font-size: 20px;"></i></th>
    </tr>
    @if($comments->isNotEmpty())
        @include('rix.layouts.components.comments.table-content')
    @endif
</table>
@section('js')
    <script src="/rix//assets/js/page/features-posts.js"></script>
    <script src="/rix//assets/js/page/components-table.js"></script>
    <script>
        let pending = '{{isset($typeData->pending) ? $typeData->pending : 0}}';
        if (pending > 0)
            $('#beepMessage').addClass('beep beep-sidebar custom-beep');
    </script>
@append