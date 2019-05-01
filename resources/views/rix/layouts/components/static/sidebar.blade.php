<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('rix_home')}}">Rix Admin</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('rix_home')}}">Rix</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Anasayfa</li>
            <li class="active"><a class="nav-link" href="{{route('rix_home')}}"><i class="fas fa-fire"></i> <span>Anasayfa</span></a></li>
            <li class="menu-header">Starter</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">Default Layout</a></li>
                    <li><a class="nav-link" href="#">Transparent Sidebar</a></li>
                    <li><a class="nav-link" href="#">Top Navigation</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
