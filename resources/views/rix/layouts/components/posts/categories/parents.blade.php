<option value="0">Yok</option>
@if(!empty($categories['for_parents']))
    @foreach($categories['for_parents'] as $category)
        <option value="{{$category->term_id}}">{{$category->name}}</option>
    @endforeach
@endif
