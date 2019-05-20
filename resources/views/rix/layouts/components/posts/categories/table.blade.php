<div class="table-responsive" id="categories">
    @if(!empty($tableItems))
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
            @foreach($tableItems as $item)
                <tr>
                    <td class="p-0 text-center">
                        <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$item->term_id}}" id="checkbox-{{$item->term_id}}">
                            <label for="checkbox-{{$item->term_id}}" class="custom-control-label">&nbsp;</label>
                        </div>
                    </td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->slug}}</td>
                    <td>{{$item->termTaxonomy->count}}</td>
                    <td>{{$item->readable_date}}</td>
                    <td>
                        <div class="btn-group dropleft">
                            <button type="button" class="btn custom-btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu dropleft">
                                <a class="dropdown-item has-icon" href="javascript:;" id="parentCategories" data-id="{{$item->term_id}}" data-name="{{$item->name}}">
                                    <i class="far fa-eye"></i>Alt Kategorileri Gör</a>
                                <a class="dropdown-item has-icon" href="{{route('rix_categories',['action' => 'edit','id' => $item->term_id])}}"><i class="far fa-edit"></i> Düzenle</a>
                                <a class="dropdown-item has-icon" href="javascript:;" id="singleDeleteInTable" style="color:red;" data-id="{{$item->term_id}}"><i class="far
                                fa-trash-alt"></i>
                                    Sil</a>
                                <a class="dropdown-item has-icon" href="#" target="_blank"><i class="fas fa-share"></i> Git</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="pagination float-right mr-3">{{$tableItems->links()}}</div>
    @endif
</div>

