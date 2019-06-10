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
            @php
                $add->setHeader("Genel");
                $add->setPage('Anasayfa','rix_home','ion ion-ios-home-outline');
                $add->setSubPage('Ortam','ion ion-ios-camera-outline',[['Resimler','rix_gallery'],['Yeni Ekle','rix_new_media']]);
                $add->setSubPage('Yazılar','ion ion-pin',[
                        ['Bütün Yazılar','rix_posts'],
                        ['Yazı Ekle','rix_new_post'],
                        ['Kategoriler','rix_categories'],
                        ['Etiketler','rix_tags']
                   ]);
                $add->setPage('Yorumlar','rix_comments','far fa-comment');
                $add->setHeader("Site Ayarları");
            @endphp
        </ul>
    </aside>
</div>
