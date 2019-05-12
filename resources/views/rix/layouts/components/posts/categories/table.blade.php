<div class="table-responsive" id="categories">
    @if(!empty($categories['for_table']))
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
            @foreach($categories['for_table'] as $category)
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
                    <td>
                        <div class="dropdown d-inline">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"></button>
                            <div class="dropdown-menu" x-placement="bottom-start">
                                <a class="dropdown-item has-icon" href="javascript:;" id="parentCategories" data-id="{{$category->term_id}}" data-name="{{$category->name}}">
                                    <i class="far fa-eye"></i>Alt Kategorileri Gör</a>
                                <a class="dropdown-item has-icon" href="#"><i class="far fa-edit"></i> Düzenle</a>
                                <a class="dropdown-item has-icon" href="#" style="color:red;"><i class="far fa-trash-alt"></i> Sil<a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="pagination float-right mr-3">{{$categories['for_table']->links()}}</div>
    @endif
</div>
<div id="parentCategoriesContent"></div>
