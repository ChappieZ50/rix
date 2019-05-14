$('#txt_src').on('keyup', function () {
    $('#txt_trg').val(stringToSlug($(this).val()))
});
$(document).on('click', '#publish', function () {
    let name = $('input[name=name]').val(),
        slug = $('input[name=slug]').val();
    progressForPublish(1);
    simplePost({
        name: name, slug: slug
    }, add_tag).done(function (res) {
        ajaxCheckStatus(res, {successMessage: 'Etiket Başarıyla Eklendi',});
        if (res.status !== false) {
            $('#tags').html(res.content.original.html).promise().done(function () {
                progressForPublish();
                $('input[name=name],input[name=slug]').val('');
            });
        } else {
            progressForPublish();
        }
    }).fail(function (res) {
        ajaxCheckStatus(res, {status: 500});
    });
});
