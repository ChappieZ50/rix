<option value="0">Yok</option>
@if(!empty($allCategories))
    @foreach($allCategories as $category)
        <option value="{{$category->term_id}}">{{$category->name}}</option>
    @endforeach
@endif
