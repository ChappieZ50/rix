$('#txt_src').on('keyup', function () {
    $('#txt_trg').val(stringToSlug($(this).val()))
});
$(document).on('click', '.newTag #publish', function () {
    let name = $('input[name=name]').val(),
        slug = $('input[name=slug]').val(),
        area = '.newTag';
    progressForPublish(1, area);
    simplePost({
        name: name, slug: slug
    }, tag).done(function (res) {
        console.log(res);
        ajaxCheckStatus(res, {successMessage: 'Etiket Başarıyla Eklendi', area: area});
        if (res.status !== false) {
            if ($('#closeSearch').is(':hidden')) {
                $('#tags').html(res.html);
            }
            progressForPublish(0, area);
            $('input[name=name],input[name=slug]').val('');
        } else {
            progressForPublish(0, area);
        }
    }).fail(function (res) {
        ajaxCheckStatus(res, {status: 500});
        console.log(res.responseText);
    });
});

function deleteTags(ids) {
    simplePost({ids: ids}, tag, 'delete').done(function (res) {
        ajaxCheckStatus(res, {successMessage: 'Başarıyla Silindi', errorTitle: 'Silinemedi', area: '.newTag'});
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



// Update Tag
function updateTag(id) {
    let prefix = '.newTag ',
        name = $(prefix + 'input[name=name]').val(),
        slug = $(prefix + 'input[name=slug]').val(),
        updateClass = ' #update';
    progressForPublish(1, prefix, updateClass);
    simplePost({name: name, slug: slug, id: id}, tag, 'put').done(function (res) {
        ajaxCheckStatus(res, {successMessage: 'Etiket Başarıyla Güncellendi', area: prefix});
        console.log(res);
        if (res.status !== false) {
            $('#tags').html(res.html);
            $('.newTag .card-header h4 span').text(name);
            progressForPublish(0,prefix,updateClass);
            progressForPublish(0, prefix, updateClass);
        } else {
            progressForPublish(0, prefix, updateClass);
        }

    }).fail(function (res) {
        ajaxCheckStatus(res, {status: 500});
        progressForPublish(0, prefix, updateClass);
        console.log(res.responseText);
    });
}

// Search Tag

$('#searchInTags').keyup(function (e) {
    if (e.keyCode === 13 && $.trim($(this).val()).length > 0)
        searchInTags($.trim($(this).val()));
});
$('#searchTagsBtn').on('click', function () {
    let input = $('#searchInTags');
    if ($.trim(input.val()).length > 0)
        searchInTags($.trim(input.val()));
});
$('#closeSearch').on('click', function () {
    closeSearch();
});

function searchInTags(value) {
    $('#closeSearch').show();
    simplePost({action: 'search', value: value}, tag, 'get').done(function (res) {
        $('#tagsTable').html(res.html);
        if (res.data.data.length <= 0)
            $('#tags').after('<div class="text-center mb-3"><b><h6>Aradığınız kategori bulunamadı.</h6></b></div>');
        console.log($('#tagsTable').html());
    }).fail(function (res) {
        console.log(res.responseText);
        ajaxCheckStatus(res, {status: 500});
    })
}

function closeSearch() {
    $('#closeSearch').hide();
    $('#searchInCategories').val('');
    simplePost({action: 'getTable'}, tag, 'get').done(function (res) {
        console.log(res);
        $('#tagsTable').html(res.html);
    }).fail(function (res) {
        console.log(res.responseText);
        ajaxCheckStatus(res, {status: 500});
    });
}
