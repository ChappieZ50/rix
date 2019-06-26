<table class="table table-striped" id="users">
    <tr>
        <th>#</th>
        <th>Başlık</th>
        <th>Durum</th>
        <th>Oluşturma Tarihi</th>
    </tr>
    @if($pages->isNotEmpty())
        @include('rix.layouts.components.pages.table-content')
    @endif
</table>

@section('js')
    <script src="/rix//assets/js/page/features-posts.js"></script>
    <script src="/rix//assets/js/page/components-table.js"></script>
@append

