<div class="modal fade" id="parentCategoriesModal" tabindex="-1" role="dialog" aria-labelledby="parentCategoriesModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if(!empty($parentCategories->records))
                    <div class="d-flex justify-content-start align-items-start p-3">
                        <select class="form-control" name="action" data-area="#parents" style="border-radius: 0 !important;height: 30px;padding: 5px;width: 140px;">
                            <option>Seçilene Uygula</option>
                            <option value="delete">Sil</option>
                        </select>
                        <button class="btn btn-sm btn-primary ml-1" style="box-shadow: none;border-radius: 0;" type="button" id="deleteInParents">Uygula</button>
                    </div>
                @endif
                <h5 class="modal-title" id="exampleModalLongTitle">{{!empty($parentCategories->main) ? $parentCategories->main : null}}</h5>

            </div>
            <div class="modal-body">
                <div class="table-responsive" id="parents">
                    @if(!$parentCategories->records->isEmpty())
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    <div class="custom-checkbox custom-control text-center">
                                        <input type="checkbox" data-checkboxes="parents" data-checkbox-role="parents" class="custom-control-input" id="checkbox-parents">
                                        <label for="checkbox-parents" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th>İsim</th>
                                <th>Slug</th>
                                <th>Toplam</th>
                                <th>Oluşturma Tarihi</th>
                            </tr>
                            @foreach($parentCategories->records as $category)
                                <tr>
                                    <td class="p-0 text-center">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkbox="parents" class="custom-control-input" value="{{$category->term_id}}"
                                                   id="parent-checkbox-{{$category->term_id}}">
                                            <label for="parent-checkbox-{{$category->term_id}}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        {{$category->name}}
                                        <div class="table-links actions">
                                            <a href="{{route('rix_categories',['action' => 'edit','id' => $category->term_id])}}" class="text-primary">Düzenle</a>
                                            <div class="bullet"></div>
                                            <a href="#" class="text-danger" id="singleDeleteInParents" data-id="{{$category->term_id}}">Sil</a>
                                            <div class="bullet"></div>
                                            <a href="#" class="text-primary" target="_blank">Git</a>
                                        </div>
                                    </td>
                                    <td>{{$category->slug}}</td>
                                    <td>{{$category->count}}</td>
                                    <td>{{$category->readable_date}}</td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <h5 class="text-center">Alt kategorisi yok</h5>
                    @endif

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
