<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-body">
                <ul class="nav nav-pills">
                    {!! \App\Helpers\Helper::createTablePagesBar($typeData, (object) ['all' => 'Hepsi' ,'admin' => 'Yönetici','editor' => 'Yazar','user' => 'Kullanıcı','banned' => 'Yasaklı'],true) !!}
                </ul>
            </div>
        </div>
    </div>
</div>