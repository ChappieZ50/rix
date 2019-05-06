<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('rix_home')}}">Rix Admin</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('rix_home')}}">Rix</a>
        </div>
        <ul class="sidebar-menu">
            @php $add = new \App\Helpers\Pages(); @endphp
            {!! $add->setHeader("Genel") !!}
            @php 
                $add->setPage('Anasayfa','rix_home','ion ion-flame');
                $add->setSubPage('Ortam','ion ion-ios-camera-outline',[['Resimler','rix_gallery'],['Yeni Ekle','rix_new_media']]);
                $add->setSubPage('Blog','ion ion-pin',[['Yazılar','rix_posts'],['Yazı Ekle','rix_new_post']]);
                $add->renderPages();
            @endphp
        </ul>
    </aside>
</div>
