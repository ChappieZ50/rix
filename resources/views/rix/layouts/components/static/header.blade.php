<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
        <div class="search-element">
            <input class="form-control" type="search" placeholder="Ara" aria-label="Ara" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
                <div class="search-item">
                    <a href="#">How to hack NASA using CSS</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
                {{-- <div class="search-header">
                    Result
                </div>
                <div class="search-item">
                    <a href="#">
                        <img class="mr-3 rounded" width="30" src="/rix/assets/img/products/product-3-50.png" alt="product">
                        oPhone S9 Limited Edition
                    </a>
                </div> --}}
            </div>
        </div>
    </form>
    <ul class="navbar-nav navbar-right">
        @if($composeMessages->isNotEmpty())
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">Okunmamış Mesajlar</div>
                    <div class="dropdown-list-content dropdown-list-message">
                        @foreach($composeMessages as $composeMessage)
                            <a href="{{route('rix_messages',['message' => $composeMessage->message_id])}}" class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-avatar">
                                    <img alt="image" src="/rix/assets/img/avatar/avatar-1.png" class="rounded-circle">
                                </div>
                                <div class="dropdown-item-desc">
                                    <b>{{$composeMessage->name}}</b>
                                    <p>{{\App\Helpers\Helper::longText($composeMessage->message,['len' => 120])}}</p>
                                    <div class="time">{{$composeMessage->readable_date}}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="dropdown-footer text-center">
                        <a href="{{route('rix_messages',['status' => 'unread'])}}">Hepsi <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </li>
        @endif
        @if($composeComments->isNotEmpty())
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i
                            class="ion ion-chatbubbles"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">Onaylanmamış Yorumlar
                    </div>
                    <div class="dropdown-list-content dropdown-list-icons">
                        @foreach($composeComments as $composeComment)
                            <a href="{{route('rix_comments',['comment' => $composeComment->comment_id])}}" class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-avatar">
                                    <img alt="image" src="{{!empty($composeComment->user->avatar) ? url(asset('storage/avatars').'/'.$composeComment->user->avatar) : '/rix/assets/img/avatar/avatar-1.png'}}" class="rounded-circle">
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
                        <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </li>
        @endif
        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{!empty(Auth::user()->avatar) ? url(asset('storage/avatars').'/'.Auth::user()->avatar) : '/rix/assets/img/avatar/avatar-1.png'}}"
                     class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Merhaba, {{Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="" class="dropdown-item has-icon"><i class="far fa-user"></i> Profil</a>
                <a href="{{route('rix_logout')}}" class="dropdown-item has-icon"><i class="ion ion-power"></i>Çıkış Yap</a>
            </div>
        </li>
    </ul>
</nav>
