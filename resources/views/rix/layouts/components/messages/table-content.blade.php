@foreach($messages as $message)
    <tr @if($message->status == 'unread' && Request::get('status') != 'unread') style="background:#FEF7F1;border-left:4px solid #ffb144;" @endif>
        <td class="p-0 text-center">
            <div class="custom-checkbox custom-control">
                <input type="checkbox" data-checkbox="records" class="custom-control-input" value="{{$message->message_id}}"
                       id="checkbox-{{$message->message_id}}" data-status="{{$message->status}}">
                <label for="checkbox-{{$message->message_id}}" class="custom-control-label">&nbsp;</label>
            </div>
        </td>
        <td>
            <div class="mt-2">
                {{$message->name}}
            </div>
            <div class="table-links actions" data-id="{{$message->message_id}}" data-status="{{$message->status}}">
                @if(Request::get('status') === 'unread')
                    <a href="javascript:;" class="text-success" id="read">Okundu</a>
                    <div class="bullet"></div>
                @elseif (Request::get('status') === 'read')
                    <a href="javascript:;" class="text-danger" id="unread">Okunmadı</a>
                    <div class="bullet"></div>
                @endif
                @if(!Request::get('status') || Request::get('status') != 'read' &&  Request::get('status') != 'unread' &&  Request::get('status') != 'trash')
                    @if($message->status === 'unread')
                        <a href="javascript:;" class="text-success" id="read">Okundu</a>
                        <div class="bullet"></div>
                    @elseif($message->status === 'read')
                        <a href="javascript:;" class="text-danger" id="unread">Okunmadı</a>
                        <div class="bullet"></div>
                    @endif
                @endif
                @if(Request::get('status') === 'trash')
                    <a href="javascript:;" class="text-success" id="untrash">Geri Al</a>
                    <div class="bullet"></div>
                    <a href="javascript:;" class="text-danger" id="unread">Kalıcı Olarak Sil</a>
                @else
                    <a href="javascript:;" class="text-danger" id="trash">Çöpe Taşı</a>
                @endif
            </div>
        </td>
        <td>
            <a href="javascript:;">{{$message->email}}</a>
        </td>
        <td>
            {{$message->subject}}
        </td>
        <td>
            {{$message->message}}
        </td>
        <td>{{$message->readable_date}}</td>
    </tr>
@endforeach
