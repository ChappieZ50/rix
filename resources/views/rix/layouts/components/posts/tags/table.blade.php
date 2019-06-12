<div class="table-responsive" id="tags">
    <table class="table table-striped" style="margin-top: 20px !important;">
        <tr>
            <th>
                <div class="custom-checkbox custom-control text-center">
                    <input type="checkbox" data-checkboxes="records" data-checkbox-role="records" class="custom-control-input" id="checkbox-records">
                    <label for="checkbox-records" class="custom-control-label">&nbsp;</label>
                </div>
            </th>
            <th>İsim</th>
            <th>Slug</th>
            <th>Oluşturma Tarihi</th>
            <th>İşlem</th>
        </tr>
        @if($tags->isNotEmpty())
            @foreach($tags as $tag)
                <tr>
                    <td class="p-0 text-center">
                        <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$tag->term_id}}" id="checkbox-{{$tag->term_id}}">
                            <label for="checkbox-{{$tag->term_id}}" class="custom-control-label">&nbsp;</label>
                        </div>
                    </td>
                    <td>{{$tag->name}}</td>
                    <td>{{$tag->slug}}</td>
                    <td>{{$tag->readable_date}}</td>
                    <td>
                        <div class="btn-group dropleft">
                            <button type="button" class="btn custom-btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu dropleft">
                                <a class="dropdown-item has-icon" href="{{route('rix_tags',['action' => 'edit','id' => $tag->term_id])}}"><i class="far fa-edit"></i>
                                    Düzenle</a>
                                <a class="dropdown-item has-icon" href="javascript:;" id="singleDeleteInTable" style="color:red;" data-id="{{$tag->term_id}}"><i
                                            class="far fa-trash-alt"></i> Sil</a>
                                <a class="dropdown-item has-icon" href="#" target="_blank"><i class="fas fa-share"></i> Git</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
    <div class="pagination float-right mr-3">{{$tags->appends($_GET)->links()}}</div>
    @if($tags->isEmpty())
        <div class="pl-3 pb-3">
            <span style="font-size: 15px;color:gray;">Etiket Bulunamadı</span>
        </div>
    @endif
</div>
