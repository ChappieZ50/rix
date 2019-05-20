@if(!empty($parentItems))
    @foreach($parentItems as $item)
        @if(isset($editItem))
            @if($item->term_id != \App\Helpers\Helper::write($editItem,'term_id'))
                <option value="{{$item->term_id}}" @if(\App\Helpers\Helper::write($editItem,['termTaxonomy','parent']) == $item->term_id) selected @endif>{{$item->name}}</option>
            @endif
        @else
            <option value="{{$item->term_id}}">{{$item->name}}</option>
        @endif
    @endforeach
@endif
