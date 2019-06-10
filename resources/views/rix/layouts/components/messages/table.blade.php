<div class="table-responsive" id="comments">
    <table class="table table-striped" style="margin-top: 20px !important;">
        <tr>
            <th>
                <div class="custom-checkbox custom-control text-center">
                    <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input" id="checkbox-records">
                    <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
                </div>
            </th>
            <th style="width: 40%;">İsim</th>
            <th style="width: 15%;">Mesaj</th>
            <th style="width: 11%;">Oluşturma Tarihi</th>
            <th style="width: 6%;"><i class="fas fa-comment-alt" style="font-size: 20px;"></i></th>
            <th style="width: 5%;">İşlem</th>
        </tr>
        {{--@if($posts->isNotEmpty())
            @include('rix.layouts.components.posts.posts.posts-table-content')
        @endif--}}
    </table>
    {{--<div class="pagination float-right mr-3">{{$posts->appends($_GET)->links()}}</div>--}}
    {{--@if($posts->isEmpty())
        <div class="pl-3 pb-3">
            <span style="font-size: 15px;color:gray;">Yazı Bulunamadı.</span>
        </div>
    @endif--}}
</div>

@section('js')
    <script src="/rix/assets/js/page/components-table.js"></script>
@append

