<div class="table-responsive" id="users">
    <table class="table table-striped" style="margin-top: 20px !important;margin-bottom: 0;">
        <tr>
            <th>
                <div class="custom-checkbox custom-control text-center">
                    <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input"
                           id="checkbox-records">
                    <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
                </div>
            </th>
            <th>Avatar</th>
            <th>Adı</th>
            <th>Rol</th>
            <th>Durum</th>
            <th>Oluşturma Tarihi</th>
            <th>İşlem</th>
        </tr>
        @if($users->isNotEmpty())
            @include('rix.layouts.components.users.table-content')
        @endif
    </table>
    <div class="pagination float-right mr-3 mt-3">{{$users->appends($_GET)->links()}}</div>
    @if($users->isEmpty())
        <div class="pl-3 pb-3">
            <span style="font-size: 15px;color:gray;">Kullanıcı Bulunamadı</span>
        </div>
    @endif
</div>

@section('js')
    <script src="/rix//assets/js/page/features-posts.js"></script>
@append

