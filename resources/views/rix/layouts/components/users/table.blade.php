<table class="table table-striped" id="users">
    <tr>
        <th>
            <div class="custom-checkbox custom-control text-center">
                <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input"
                       id="checkbox-records">
                <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
            </div>
        </th>
        <th>Kullanıcı Adı</th>
        <th>İsmi</th>
        <th>Avatar</th>
        <th>Rol</th>
        <th>Oluşturma Tarihi</th>
        <th>Yazı</th>
        <th>Durum</th>
    </tr>
    @if($users->isNotEmpty())
        @include('rix.layouts.components.users.table-content')
    @endif
</table>

@section('js')
    <script src="/rix//assets/js/page/features-posts.js"></script>
    <script src="/rix//assets/js/page/components-table.js"></script>
@append

