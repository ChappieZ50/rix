<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-body">
                <ul class="nav nav-pills">
                    {!! \App\Helpers\Helper::createTablePagesBar($typeData, (object) ['all' => 'Hepsi' ,'open' => 'Gönderilmiş','closed' => 'Gönderilmemiş','trash' => 'Çöp'],'rix_posts') !!}
                </ul>
            </div>
        </div>
    </div>
</div>