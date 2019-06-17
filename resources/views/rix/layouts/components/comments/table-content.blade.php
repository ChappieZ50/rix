@foreach($comments as $comment)
    <tr @if($comment->status == 'pending' && Request::get('status') != 'pending') style="background:#FEF7F1;border-left:4px solid red;" @endif>
        <td class="p-0 text-center">
            <div class="custom-checkbox custom-control">
                <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$comment->comment_id}}"
                       id="checkbox-{{$comment->comment_id}}" data-status="{{$comment->status}}">
                <label for="checkbox-{{$comment->comment_id}}" class="custom-control-label">&nbsp;</label>
            </div>
        </td>
        <td>
            <div class="mt-2">{{$comment->name}}</div>
            <div class="table-links actions" data-id="{{$comment->comment_id}}" data-status="{{$comment->status}}">
                @if(Request::get('status') == 'pending')
                    <a href="javascript:;" class="text-success" id="approved">Onayla</a>
                    <div class="bullet"></div>
                @elseif (Request::get('status') == 'approved')
                    <a href="javascript:;" class="text-danger" id="pending">Onayı Kaldır</a>
                    <div class="bullet"></div>
                @endif
                @if(!Request::get('status') || Request::get('status') != 'approved' &&  Request::get('status') != 'pending' &&  Request::get('status') != 'spam')
                    @if($comment->status == 'pending')
                        <a href="javascript:;" class="text-success" id="approved">Onayla</a>
                            <div class="bullet"></div>
                    @elseif($comment->status == 'approved')
                        <a href="javascript:;" class="text-danger" id="pending">Onayı Kaldır</a>
                            <div class="bullet"></div>
                        @endif
                @endif
                @if(Request::get('status') == 'spam')
                    <a href="javascript:;" class="text-success" id="unspam">Spamdan Kaldır</a>
                        <div class="bullet"></div>
                @else
                    <a href="javascript:;" class="text-danger" id="spam">Spam Olarak İşaretle</a>
                        <div class="bullet"></div>
                @endif
                <a href="javascript:;" class="text-danger" id="delete">Kalıcı Olarak Sil</a>
            </div>
        </td>
        <td>
            <a href="javascript:;">{{$comment->email}}</a>
        </td>
        <td>
            {{$comment->comment}}
        </td>
        <td>{{$comment->readable_date}}</td>
        <td>
            <a href="{{Request::fullUrlWithQuery(['post' => $comment->post->post_id])}}" class="comment">
                <span class="comment-count">1</span>
            </a>
        </td>
    </tr>
@endforeach
