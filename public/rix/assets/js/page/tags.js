$('#txt_src').on('keyup', function () {
    $('#txt_trg').val(stringToSlug($(this).val()))
});
$(document).on('click', '.newTag #publish', function () {
    let name = $('input[name=name]').val(),
        slug = $('input[name=slug]').val(),
        area = '.newTag';
    progressForPublish(1,area);
    simplePost({
        name: name, slug: slug
    }, add_tag).done(function (res) {
        console.log(res);
        ajaxCheckStatus(res, {successMessage: 'Etiket Başarıyla Eklendi',area:area});
        if (res.status !== false) {
            $('#tags').html(res.html).promise().done(function () {
                progressForPublish(0, area);
                $('input[name=name],input[name=slug]').val('');
            });
        } else {
            progressForPublish(0,area);
        }
    }).fail(function (res) {
        ajaxCheckStatus(res, {status: 500});
        console.log(res.responseText);
    });
});

function deleteTags(ids) {
    simplePost({ids: ids}, add_tag, 'delete').done(function (res) {
        ajaxCheckStatus(res, {successMessage: 'Başarıyla Silindi', errorTitle: 'Silinemedi',area:'.newTag'});
        $('#tags').html(res.html);
    }).fail(function (res) {
        ajaxCheckStatus(res, {status: 500});
        console.log(res.responseText);
    })
}

$(document).on('click', '.newTag #deleteInTable', function () {
    $('select[name=action]').each(function () {
        if ($(this).val() == 'delete') {
            let values = $('#tags input[type=checkbox]:checked').not('[data-checkbox-role]').map(function () {
                return this.value;
            }).get();
            if (values.length > 0)
                deleteTags(values);
        }
    });
});
$(document).on('click', '.newTag #singleDeleteInTable', function () {
    if (confirm('Silmek istediğinizden emin misiniz ?')) {
        let id = $(this).attr('data-id');
        if (id.length > 0)
            deleteTags(id);
    }
});
