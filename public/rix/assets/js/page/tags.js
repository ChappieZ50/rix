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
