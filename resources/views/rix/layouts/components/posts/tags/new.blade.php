<div class="card">
    <div class="card-header">
        <h4>Etiket Ekle</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label>İsim</label>
            <input type="text" class="form-control" name="name" id="txt_src">
            <div class="invalid-feedback" data-name="name"></div>
        </div>
        <div class="form-group">
            <label>Slug</label>
            <input type="text" class="form-control" id="txt_trg" name="slug">
            <div class="invalid-feedback" data-name="slug"></div>
        </div>
        <button class="btn btn-primary" id="publish">Etiketi Ekle</button>
        <button type="button" class="btn disabled btn-primary btn-progress" style="display: none;">Progress</button>
    </div>
</div>
@section('js')
    <script src="/rix/assets/js/custom.js"></script>
    <script src="/rix/assets/js/simple-post.js"></script>
    <script>
        $('#txt_src').on('keyup', function () {
            $('#txt_trg').val(stringToSlug($(this).val()))
        });
        $(document).on('click', '#publish', function () {
            let progress = $('.btn-progress'),
                publish = $(this),
                name = $('input[name=name]').val(),
                slug = $('input[name=slug]').val();
            progress.show();
            publish.hide();
            simplePost({
                name: name, slug: slug
            }, add_tag).done(function (res) {
                ajaxCheckStatus(res, {
                    successMessage: 'Etiket Başarıyla Eklendi',
                });
                if (res.status !== false) {
                    $('#tags').html(res.content.original.html).promise().done(function () {
                        progress.hide();
                        publish.show();
                        $('input[name=name],input[name=slug]').val('');
                    });
                }else{
                    progress.hide();
                    publish.show();
                }
            }).fail(function (res) {
                ajaxCheckStatus(res, {
                    status: 500
                });
            });
        });
    </script>
@append
