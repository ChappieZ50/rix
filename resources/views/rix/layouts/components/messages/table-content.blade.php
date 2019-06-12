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
            {{$message->name}}
            <br>
            <a href="javascript:;">{{$message->email}}</a>
        </td>
        <td>
            {{$message->subject}}
        </td>
        <td>
            {{$message->message}}
        </td>
        <td>{{$message->readable_date}}</td>
        <td>
            <div class="btn-group dropleft">
                <button type="button" class="btn custom-btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"></button>
                <div class="dropdown-menu dropleft actions" data-id="{{$message->message_id}}" data-status="{{$message->status}}">
                    @if(Request::get('status') === 'unread')
                        <a class="dropdown-item has-icon" href="javascript:;" style="color:green;" id="read"><i
                                    class="ion ion-ios-checkmark"></i>
                            Okundu</a>
                    @elseif (Request::get('status') === 'read')
                        <a class="dropdown-item has-icon" href="javascript:;" id="unread" style="color:red"><i class="ion ion-close-circled"></i>Okunmadı</a>
                    @endif
                    @if(!Request::get('status') || Request::get('status') != 'read' &&  Request::get('status') != 'unread' &&  Request::get('status') != 'trash')
                        @if($message->status === 'unread')
                            <a class="dropdown-item has-icon" href="javascript:;" style="color:green;" id="read"><i
                                        class="ion ion-ios-checkmark"></i>
                                Okundu</a>
                        @elseif($message->status === 'read')
                            <a class="dropdown-item has-icon" href="javascript:;" id="unread" style="color:red;"><i
                                        class="ion ion-close-circled"></i>
                                Okunmadı</a>
                        @endif
                    @endif
                    @if(Request::get('status') === 'trash')
                        <a class="dropdown-item has-icon" href="javascript:;" style="color:green;" id="untrash"><i
                                    class="ion ion-ios-checkmark"></i>
                            Geri Al</a>
                        <a class="dropdown-item has-icon" href="javascript:;" id="delete" style="color:red;"><i
                                    class="far fa-trash-alt"></i>Kalıcı Olarak Sil</a>
                    @else
                        <a class="dropdown-item has-icon" href="javascript:;" id="trash" style="color:red;"><i class="far fa-trash-alt"></i>Çöpe
                            Taşı</a>
                    @endif
                </div>
            </div>
        </td>
    </tr>
@endforeach
