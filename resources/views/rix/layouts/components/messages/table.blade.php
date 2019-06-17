<table class="table table-striped" id="messages">
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
        <th>Konu</th>
        <th style="width: 40%;">Mesaj</th>
        <th>Oluşturma Tarihi</th>
    </tr>
    @if($messages->isNotEmpty())
        @include('rix.layouts.components.messages.table-content')
    @endif
</table>
@section('js')
    <script src="/rix//assets/js/page/features-posts.js"></script>
    <script src="/rix//assets/js/page/components-table.js"></script>
@append
