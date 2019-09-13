<header id="header" id="home">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-4 header-top-left no-padding">
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-sm-6 col-8 header-top-right no-padding">
                    <a href="tel:+880 012 3654 896">+880 012 3654 896</a>
                    <a href="mailto:support@colorlib.com">destek@hayalimparke.com</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-menu">
        <div class="row align-items-center justify-content-between d-flex">
            <div id="logo">
                <a href="{{route('view.home')}}"><img src="/img/logo.png" width="230" alt="" title="" /></a>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="menu-active"><a href="{{route('view.home')}}">Anasayfa</a></li>
                    <li class="menu-has-children"><a href="javascript:;">Keşif</a>
                    <ul>
                        <li><a href="">Keşif İste</a></li>
                        <li><a href="">Fiyat Öğren</a></li>
                    </ul>
                    </li>
                    <li><a href="{{route('view.discovery')}}">Keşif</a></li>
                    <li><a href="{{route('view.references')}}">Referanslar</a></li>
                    <li><a href="{{route('view.gallery')}}">Galeri</a></li>
                    <li><a href="{{route('view.about')}}">Hakkımızda</a></li>
                    <li><a href="{{route('view.contact')}}">İletişim</a></li>
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </div>
</header><!-- #header -->