@foreach($posts as $post)
    @php($helper = new \App\Helpers\Helper())
    <tr>
        <td class="p-0 text-center">
            <div class="custom-checkbox custom-control">
                <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$post->post_id}}" id="checkbox-{{$post->post_id}}" data-status="{{$post->status}}">
                <label for="checkbox-{{$post->post_id}}" class="custom-control-label">&nbsp;</label>
            </div>
        </td>
        <td>{{$post->title}} {!! $post->status == 'closed' && $type != 'closed' ? '<b>— Gönderilmemiş </b>' : null !!}
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
            <a href="#" class="comment">
                <span class="comment-count">1</span>
            </a>
        </td>
        <td>
            <div class="btn-group dropleft">
                <button type="button" class="btn custom-btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu dropleft">
                    <a href="{{route('rix_post',['action' => 'edit','id' => $post->post_id])}}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Düzenle</a>
                    @if($type == 'trash')
                        <a class="dropdown-item has-icon" href="javascript:;" id="restore" data-id="{{$post->post_id}}"><i class="fas fa-trash-restore-alt"></i>Geri Al</a>
                        <a class="dropdown-item has-icon" href="javascript:;" id="singlePermanentlyDelete" style="color:red;" data-id="{{$post->post_id}}" data-status="{{$post->status}}"><i
                                class="far fa-trash-alt"></i>Kalıcı Olarak Sil</a>
                    @else
                        <a class="dropdown-item has-icon" href="javascript:;" id="singleToTrash" style="color:red;" data-id="{{$post->post_id}}" data-status="{{$post->status}}"><i class="far
                        fa-trash-alt"></i>Çöpe Taşı</a>
                    @endif

                    <a class="dropdown-item has-icon" href="#" target="_blank"><i class="fas fa-share"></i> Git</a>
                </div>
            </div>
        </td>
    </tr>
@endforeach
