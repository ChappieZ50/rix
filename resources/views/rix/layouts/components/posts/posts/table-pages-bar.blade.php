<a href="{{route('rix_posts')}}" {{$type != 'closed' && $type != 'trash'  ? 'class=page-active' : null}}>Hepsi
    <span class="count">({{$all}})</span>
</a>
@if($closed > 0)
    |
    <a href="{{route('rix_posts',['type' => 'closed'])}}" {{$type == 'closed'  ? 'class=page-active' : null }}>Gönderilmemiş
        <span class="count">({{$closed}})</span>
    </a>
@endif

@if($trash > 0)
    |
    <a href="{{route('rix_posts',['type' => 'trash'])}}" {{$type == 'trash'  ? 'class=page-active' : null }}>Çöp
        <span class="count">({{$trash}})</span>
    </a>
@endif
