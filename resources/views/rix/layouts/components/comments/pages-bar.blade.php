@php($post = ['post' => Request::get('post')])
<a href="{{route('rix_comments',!empty($post['post']) ? $post : [])}}"   @if(!$typeData->type || $typeData->type != 'approved' && $typeData->type != 'pending' && $typeData->type != 'spam')  class="page-active" @endif>Hepsi <span class="count"> ({{$typeData->all}})</span></a>

@if(!empty($typeData->approved))<a href="{{route('rix_comments',['status' => 'approved'] + $post)}}" @if($typeData->type == 'approved')  class="page-active" @endif>Onaylanmış <span class="count"> ({{$typeData->approved}})</span></a>@endif
@if(!empty($typeData->pending))<a href="{{route('rix_comments',['status' => 'pending'] + $post)}}" @if($typeData->type == 'pending')  class="page-active" @endif> Onaylanmamış <span class="count"> ({{$typeData->pending}})</span></a>@endif
@if(!empty($typeData->spam))<a href="{{route('rix_comments',['status' => 'spam'] + $post)}}" @if($typeData->type == 'spam')  class="page-active" @endif> Spam <span class="count"> ({{$typeData->spam}})</span></a>@endif