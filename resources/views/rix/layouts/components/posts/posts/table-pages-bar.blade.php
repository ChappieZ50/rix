<a href="{{route('rix_posts')}}" {{Request::get('type') == 'trash' || Request::get('type') == 'closed' ?  : 'class=page-active'}}>Hepsi
    <span class="count">({{$all}})</span>
</a>
@if($closed > 0)
    |
    <a href="{{route('rix_posts',['type' => 'closed'])}}" {{Request::get('type') == 'closed' ? 'class=page-active' : null }}>Gönderilmemiş
        <span class="count">({{$closed}})</span>
    </a>
@endif

@if($trash > 0)
    |
    <a href="{{route('rix_posts',['type' => 'trash'])}}" {{Request::get('type') == 'trash' ? 'class=page-active' : null }}>Çöp
        <span class="count">({{$trash}})</span>
    </a>
@endif
