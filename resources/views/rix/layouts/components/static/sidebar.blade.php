<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('rix.home')}}">@if(isset($composePanelName) && !empty($composePanelName)) {{$composePanelName}} @else Rix Admin @endif</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('rix.home')}}">Rix</a>
        </div>
        <ul class="sidebar-menu">
            @php $add = new \App\Helpers\Pages(); @endphp
            @php
                $add->setHeader("Genel");
                $add->setPage('Anasayfa','rix.home',['icon' => 'ion ion-ios-home-outline']);
                $add->setSubPage('Ortam','ion ion-ios-camera-outline',[['Resimler','rix.gallery'],['Yeni Ekle','rix.new_media']]);
                $add->setSubPage('Yazılar','ion ion-pin',[
                        ['Bütün Yazılar','rix.posts'],
                        ['Yazı Ekle','rix.new_post'],
                        ['Kategoriler','rix.categories'],
                        ['Etiketler','rix.tags']
                   ]);
                if(Auth::user()->role == 'admin'){ $add->setSubPage('Sayfalar','ion ion-ios-paper-outline',[['Bütün Sayfalar','rix.pages'],['Yeni Ekle','rix.page']]);}
                $add->setPage('Yorumlar','rix.comments',['icon' => 'ion ion-ios-chatbubble-outline','size' => 19]);
                if(Auth::user()->role == 'admin'){
                 $add->setPage('Mesajlar','rix.messages',['icon' => 'ion ion-ios-email-outline','size' => 19]);
                 $add->setSubPage('Bülten','ion ion-speakerphone',[
                    ['Aboneler','rix.subscriptions'],
                    ['Abonelere Mail Gönder','rix.send_email_subscriptions'],
                 ]);
                 $add->setSubPage('Kullanıcılar','far fa-user',[['Bütün Kullanıcılar','rix.users'],['Yeni Ekle','rix.user'],['Profil','rix.profile']]);
                 $add->setPage('Ayarlar','rix.settings.setting',['icon' => 'ion ion-gear-a','size' => 19]);
                }else{
                    $add->setPage('Profil','rix.profile',['icon' => 'far fa-user','size' => 19]);
                }
            @endphp
        </ul>
    </aside>
</div>
