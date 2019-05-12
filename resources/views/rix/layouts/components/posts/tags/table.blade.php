<div class="table-responsive" id="tags">
    @if(!empty($tags))
        <table class="table table-striped">
            <tr>
                <th>
                    <div class="custom-checkbox custom-control text-center">
                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                    </div>
                </th>
                <th>İsim</th>
                <th>Slug</th>
                <th>Oluşturma Tarihi</th>
                <th>İşlem</th>
            </tr>
            @foreach($tags as $tag)
                <tr>
                    <td class="p-0 text-center">
                        <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" value="{{$tag->term_id}}" id="checkbox-{{$tag->term_id}}">
                            <label for="checkbox-{{$tag->term_id}}" class="custom-control-label">&nbsp;</label>
                        </div>
                    </td>
                    <td>{{$tag->name}}</td>
                    <td>{{$tag->slug}}</td>
                    <td>{{$tag->readable_date}}</td>
                    <td><a href="#" class="btn btn-secondary">Düzenle</a></td>
                </tr>
            @endforeach
        </table>
        <div class="pagination float-right mr-3">{{$tags->links()}}</div>
    @endif
</div>
