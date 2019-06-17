@foreach($tags as $tag)
    <tr>
        <td class="p-0 text-center">
            <div class="custom-checkbox custom-control">
                <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$tag->term_id}}" id="checkbox-{{$tag->term_id}}">
                <label for="checkbox-{{$tag->term_id}}" class="custom-control-label">&nbsp;</label>
            </div>
        </td>
        <td>
            {{$tag->name}}
            <div class="table-links actions">
                <a href="{{route('rix_tags',['action' => 'edit','id' => $tag->term_id])}}" class="text-primary">Düzenle</a>
                <a href="#" class="text-primary" target="_blank">Git</a>
                <a href="#" class="text-danger" id="singleDeleteInTable" data-id="{{$tag->term_id}}">Sil</a>
            </div>
        </td>
        <td>{{$tag->slug}}</td>
        <td>{{$tag->readable_date}}</td>
    </tr>
@endforeach
