<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-body">
                <ul class="nav nav-pills">
                    {!! \App\Helpers\Helper::createTablePagesBar($typeData, (object) ['all' => 'Hepsi' ,'approved' => 'Onaylanmış','pending' => 'Onaylanmamış','spam' => 'Spam'],'rix.comments','status') !!}
                </ul>
            </div>
        </div>
    </div>
</div>