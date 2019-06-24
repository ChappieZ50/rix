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
                $add->setPage('Anasayfa','rix_home',['icon' => 'ion ion-ios-home-outline']);
                $add->setSubPage('Ortam','ion ion-ios-camera-outline',[['Resimler','rix_gallery'],['Yeni Ekle','rix_new_media']]);
                $add->setSubPage('Yazılar','ion ion-pin',[
                        ['Bütün Yazılar','rix_posts'],
                        ['Yazı Ekle','rix_new_post'],
                        ['Kategoriler','rix_categories'],
                        ['Etiketler','rix_tags']
                   ]);
                $add->setPage('Yorumlar','rix_comments',['icon' => 'ion ion-ios-chatbubble-outline','size' => 19,'id' => 'beepMessage']);
                if(Auth::user()->role == 'admin'){
                 $add->setPage('Mesajlar','rix_messages',['icon' => 'ion ion-ios-email-outline','size' => 19]);
                 $add->setPage('Bülten','rix_subscriptions',['icon' => 'fas fa-bullhorn','size',14]);
                 $add->setSubPage('Kullanıcılar','far fa-user',[['Bütün Kullanıcılar','rix_users'],['Yeni Ekle','rix_user'],['Profil','rix_profile']]);
                }else{
                    $add->setPage('Profil','rix_profile',['icon' => 'far fa-user','size' => 19]);
                }
            @endphp
        </ul>
    </aside>
</div>
