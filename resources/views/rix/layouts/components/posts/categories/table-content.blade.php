@foreach($tableItems as $item)
    <tr>
        <td class="p-0 text-center">
            <div class="custom-checkbox custom-control">
                <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$item->term_id}}" id="checkbox-{{$item->term_id}}">
                <label for="checkbox-{{$item->term_id}}" class="custom-control-label">&nbsp;</label>
            </div>
        </td>
        <td>
            {{$item->name}}
            <div class="table-links actions" data-id="{{$item->term_id}}">
                <a href="javascript:;" class="text-primary" id="parentCategories" data-id="{{$item->term_id}}" data-name="{{$item->name}}">Alt Kategorileri Gör</a>
                <div class="bullet"></div>
                <a href="{{route('rix.categories',['action' => 'edit','id' => $item->term_id])}}" class="text-primary">Düzenle</a>
                <div class="bullet"></div>
                <a href="javascript:;" class="text-danger" id="singleDeleteInTable" data-id="{{$item->term_id}}">Sil</a>
                <div class="bullet"></div>
                <a href="#" class="text-primary" target="_blank" data-id="{{$item->term_id}}">Git</a>
            </div>
        </td>
        <td>{{$item->slug}}</td>
        <td>{{$item->termTaxonomy->count}}</td>
        <td>{{$item->readable_date}}</td>
    </tr>
@endforeach

