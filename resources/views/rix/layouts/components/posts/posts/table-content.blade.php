@foreach($posts as $post)
    @php($helper = new \App\Helpers\Helper())
    <tr>
        <td class="p-0 text-center">
            <div class="custom-checkbox custom-control">
                <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$post->post_id}}" id="checkbox-{{$post->post_id}}"
                       data-status="{{$post->status}}">
                <label for="checkbox-{{$post->post_id}}" class="custom-control-label">&nbsp;</label>
            </div>
        </td>
        <td>

            {{$post->title}} {!! $post->status == 'closed' && $typeData->type != 'closed' ? '<b>— Gönderilmemiş </b>' : null !!}

            <div class="table-links actions">
                <a href="{{route('rix_post',['action' => 'edit','id' => $post->post_id])}}" class="text-primary">Düzenle</a>
                <div class="bullet"></div>
                @if($typeData->type == 'trash')
                    <a href="javascript:;" class="text-success" id="restore" data-id="{{$post->post_id}}">Geri Al</a>
                    <div class="bullet"></div>
                    <a href="javascript:;" class="text-danger" id="singlePermanentlyDelete" data-id="{{$post->post_id}}" data-status="{{$post->status}}">Kalıcı Olarak Sil</a>
                @else
                    <a href="javascript:;" class="text-danger" id="singleToTrash" data-id="{{$post->post_id}}" data-status="{{$post->status}}">Çöpe Taşı</a>
                    <div class="bullet"></div>
                    <a class="text-primary" href="#" target="_blank">Git</a>
                @endif
            </div>
        </td>
        @if($post->termRelationships->isNotEmpty())
            <td class="post-categories">
                {{$helper::getTerms('category',$post->termRelationships)}}
            </td>
            <td class="post-tags">
                {{$helper::getTerms('post_tag',$post->termRelationships)}}
            </td>
        @else
            <td class="post-categories">—</td>
            <td class="post-tags">—</td>
        @endif
        <td>{{$post->readable_date}}</td>
        <td>
            {{$post->user->username}}
        </td>
        <td>
            <a href="#" class="comment">
                <span class="comment-count">1</span>
            </a>
        </td>
    </tr>
@endforeach
