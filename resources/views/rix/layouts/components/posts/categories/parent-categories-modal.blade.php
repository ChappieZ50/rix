<div class="modal fade" id="parentCategoriesModal" tabindex="-1" role="dialog" aria-labelledby="parentCategoriesModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{!empty($parentCategories['main']) ? $parentCategories['main'] : null}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" id="categories">
                    @if(!empty($parentCategories['records']))
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    <div class="custom-checkbox custom-control text-center">
                                        <input type="checkbox" data-checkboxes="parents" data-role="main" class="custom-control-input" id="checkbox-all">
                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th>İsim</th>
                                <th>Slug</th>
                                <th>Toplam</th>
                                <th>Oluşturma Tarihi</th>
                                <th>İşlem</th>
                            </tr>
                            @foreach($parentCategories['records'] as $category)
                                <tr>
                                    <td class="p-0 text-center">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkbox="parents" data-role="single" class="custom-control-input" value="{{$category->term_id}}"
                                                   id="parent-checkbox-{{$category->term_id}}">
                                            <label for="parent-checkbox-{{$category->term_id}}" class="custom-control-label">&nbsp;</label>
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
                                                <a class="dropdown-item has-icon" href="#"><i class="far fa-edit"></i> Düzenle</a>
                                                <a class="dropdown-item has-icon" href="#" style="color:red;"><i class="far fa-trash-alt"></i> Sil<a>
                                                <a class="dropdown-item has-icon" href="#" style="color:red;"><i class="far fa-eye"></i> Göster<a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
