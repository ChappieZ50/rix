<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        @php $helper = new \App\Helpers\Helper(); @endphp
        @if(isset($composeMessages) && $composeMessages->isNotEmpty())
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                                                         class="nav-link nav-link-lg message-toggle beep"><i
                            class="far fa-envelope"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">Okunmamış Mesajlar</div>
                    <div class="dropdown-list-content dropdown-list-message">
                        @foreach($composeMessages as $composeMessage)
                            <a href="{{route('rix.messages',['message' => $composeMessage->message_id])}}"
                               class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-avatar">
                                    <img alt="image" src="/rix/assets/img/avatar/avatar-1.png" class="rounded-circle">
                                </div>
                                <div class="dropdown-item-desc">
                                    <b>{{$composeMessage->name}}</b>
                                    <p>{{$helper::longText($composeMessage->message,['len' => 120])}}</p>
                                    <div class="time">{{$composeMessage->readable_date}}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="dropdown-footer text-center">
                        <a href="{{route('rix.messages',['status' => 'unread'])}}">Hepsi <i
                                    class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </li>
        @endif
        @if(isset($composeComments) && $composeComments->isNotEmpty())
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                                                         class="nav-link notification-toggle nav-link-lg beep"><i
                            class="ion ion-chatbubbles"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">Onaylanmamış Yorumlar
                    </div>
                    <div class="dropdown-list-content dropdown-list-icons">
                        @foreach($composeComments as $composeComment)
                            <a href="{{route('rix.comments',['comment' => $composeComment->comment_id])}}"
                               class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-avatar">
                                    <img alt="image"
                                         src="{{!empty($composeComment->user->avatar) ? url(asset('storage/avatars').'/'.$composeComment->user->avatar) : '/rix/assets/img/avatar/avatar-1.png'}}"
                                         class="rounded-circle">
                                </div>
                                <div class="dropdown-item-desc">
                                    <b>{{isset($composeComment->user) ? $composeComment->user->username : $composeComment->name }}</b>
                                    <p>{{\App\Helpers\Helper::longText($composeComment->message,['len' => 120])}}</p>
                                    <div class="time">{{$composeComment->readable_date}}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="dropdown-footer text-center">
                        <a href="{{route('rix.comments',['status' => 'pending'])}}">Hepsi <i
                                    class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </li>
        @endif
        @if(isset($composeNotifications) && $composeNotifications->isNotEmpty())
            <li class="dropdown dropdown-list-toggle" id="liNotifications"><a href="#" data-toggle="dropdown"
                                                                              class="nav-link notification-toggle nav-link-lg beep"><i
                            class="far fa-bell"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">Bildirimler</div>
                    <div class="dropdown-list-content dropdown-list-icons">
                        @foreach($composeNotifications as $notification)
                            <a href="javascript:;" class="dropdown-item ">
                                <div class="dropdown-item-icon {{$notification->status == 'success' ? 'bg-success' : 'bg-danger'}} text-white">
                                    <i class="{{$notification->status == 'success' ? 'fas fa-check' : 'fas fa-exclamation-triangle'}}"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    <h6>{{$notification->title}}</h6>
                                    {{$notification->content}}
                                    <br>
                                    <div class="time">
                                        <strong>{{$helper::changeTimeDiff($helper::getTimeDiff($notification->created_at,null,false))}}
                                            Önce</strong></div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="dropdown-footer text-center">
                        <a href="javascript:;" id="markRead">Okundu Olarak İşaretle <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </li>
        @endif
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{$helper::getUserAvatar(Auth::user()->avatar,Auth::user()->role,false)}}"
                     class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Merhaba, {{Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{route('rix.profile')}}" class="dropdown-item has-icon"><i class="far fa-user"></i> Profil</a>
                <a href="{{route('rix.settings.setting')}}" class="dropdown-item has-icon"><i class="ion ion-gear-a"></i>
                    Ayarlar</a>
                @if(Auth::user()->role == 'admin') <a href="{{route('rix.settings.guide')}}" class="dropdown-item has-icon"><i class="far fa-newspaper"></i> Klavuz</a> @endif
                <a href="{{route('rix_logout')}}" class="dropdown-item has-icon"><i class="ion ion-power"></i>Çıkış Yap</a>
            </div>
        </li>
    </ul>
</nav>