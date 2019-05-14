<div class="table-responsive" id="categories">
    @if(!empty($categories['for_table']))
        <table class="table table-striped">
            <tr>
                <th>
                    <div class="custom-checkbox custom-control text-center">
                        <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input" id="checkbox-records">
                        <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
                    </div>
                </th>
                <th>İsim</th>
                <th>Slug</th>
                <th>Toplam</th>
                <th>Oluşturma Tarihi</th>
                <th>İşlem</th>
            </tr>
            @foreach($categories['for_table'] as $category)
                <tr>
                    <td class="p-0 text-center">
                        <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$category->term_id}}" id="checkbox-{{$category->term_id}}">
                            <label for="checkbox-{{$category->term_id}}" class="custom-control-label">&nbsp;</label>
                        </div>
                    </td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->slug}}</td>
                    <td>{{$category->count}}</td>
                    <td>{{$category->readable_date}}</td>
                    <td>
                        <div class="btn-group dropleft">
                            <button type="button" class="btn custom-btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu dropleft">
                                <a class="dropdown-item has-icon" href="javascript:;" id="parentCategories" data-id="{{$category->term_id}}" data-name="{{$category->name}}">
                                    <i class="far fa-eye"></i>Alt Kategorileri Gör</a>
                                <a class="dropdown-item has-icon" href="#"><i class="far fa-edit"></i> Düzenle</a>
                                <a class="dropdown-item has-icon" href="javascript:;" id="singleDeleteInTable" style="color:red;" data-id="{{$category->term_id}}"><i class="far
                                fa-trash-alt"></i>
                                    Sil</a>
                                <a class="dropdown-item has-icon" href="#" target="_blank"><i class="fas fa-share"></i> Git</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="pagination float-right mr-3">{{$categories['for_table']->links()}}</div>
    @endif
</div>
