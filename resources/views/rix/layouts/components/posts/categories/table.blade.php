<div class="table-responsive" id="categories">
    @if(!empty($categories))
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
                <th>Toplam</th>
                <th>Oluşturma Tarihi</th>
                <th>İşlem</th>
            </tr>
            @foreach($categories as $category)
                <tr>
                    <td class="p-0 text-center">
                        <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" value="{{$category->term_id}}" id="checkbox-{{$category->term_id}}">
                            <label for="checkbox-{{$category->term_id}}" class="custom-control-label">&nbsp;</label>
                        </div>
                    </td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->slug}}</td>
                    <td>{{$category->count}}</td>
                    <td>{{$category->readable_date}}</td>
                    <td><a href="#" class="btn btn-secondary">Düzenle</a></td>
                </tr>
            @endforeach
        </table>
        <div class="pagination float-right mr-3">{{$categories->links()}}</div>
    @endif
</div>
