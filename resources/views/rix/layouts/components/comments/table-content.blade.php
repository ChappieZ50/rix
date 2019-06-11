@foreach($comments as $comment)
    <tr @if($comment->status == 'pending' && Request::get('status') != 'pending') style="background:#FEF7F1;border-left:4px solid red;" @endif>
        <td class="p-0 text-center">
            <div class="custom-checkbox custom-control">
                <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$comment->comment_id}}"
                       id="checkbox-{{$comment->comment_id}}" data-status="{{$comment->status}}">
                <label for="checkbox-{{$comment->comment_id}}" class="custom-control-label">&nbsp;</label>
            </div>
        </td>
        <td>{{$comment->name}}</td>
        <td>
            {{$comment->comment}}
        </td>
        <td>{{$comment->readable_date}}</td>
        <td>
            <a href="{{Request::fullUrlWithQuery(['post' => $comment->post->post_id])}}" class="comment">
                <span class="comment-count">1</span>
            </a>
        </td>
        <td>
            <div class="btn-group dropleft">
                <button type="button" class="btn custom-btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"></button>
                <div class="dropdown-menu dropleft actions" data-id="{{$comment->comment_id}}" data-status="{{$comment->status}}">
                    @if(Request::get('status') == 'pending')
                        <a class="dropdown-item has-icon" href="javascript:;" style="color:green;" id="approved"><i class="ion ion-ios-checkmark"></i>
                            Onayla</a>
                    @elseif (Request::get('status') == 'approved')
                        <a class="dropdown-item has-icon" href="javascript:;" id="pending"><i class="ion ion-close-circled"></i> Onayı
                            Kaldır</a>
                    @endif
                    @if(!Request::get('status') || Request::get('status') != 'approved' &&  Request::get('status') != 'pending' &&  Request::get('status') != 'spam')
                        @if($comment->status == 'pending')
                            <a class="dropdown-item has-icon" href="javascript:;" style="color:green;" id="approved"><i class="ion ion-ios-checkmark"></i>
                                Onayla</a>
                        @elseif($comment->status == 'approved')
                            <a class="dropdown-item has-icon" href="javascript:;" id="pending"><i class="ion ion-close-circled"></i>
                                Onayı Kaldır</a>
                        @endif
                    @endif
                    @if(Request::get('status') == 'spam')
                        <a class="dropdown-item has-icon" href="javascript:;" style="color:green;" id="unspam"><i class="ion ion-ios-checkmark"></i>
                            Spamdan Kaldır</a>
                    @else
                        <a class="dropdown-item has-icon" href="javascript:;" id="spam"><i class="ion ion-android-alert"></i> Spam
                            Olarak İşaretle</a>
                    @endif
                    <a class="dropdown-item has-icon" href="javascript:;" id="delete" style="color:red;"><i
                                class="far fa-trash-alt"></i>Kalıcı Olarak Sil</a>
                </div>
            </div>
        </td>
    </tr>
@endforeach
