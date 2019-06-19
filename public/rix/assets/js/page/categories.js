$('.newCategory #txt_src').on('keyup', function () {
    $('.newCategory #txt_trg').val(stringToSlug($(this).val()))
});
/**
 * This area for create a new category
 */
$(document).on('click', '.newCategory #publish', function () {
    let prefix = '.newCategory ',
        name = $(prefix + 'input[name=name]').val(),
        slug = $(prefix + 'input[name=slug]').val(),
        parent = $(prefix + 'select[name=parent_category]').val();
    progressForPublish(1, prefix);
    simplePost({name: name, slug: slug, parent: parent}, category).done(function (res) {
        ajaxCheckStatus(res, {successMessage: 'Kategori Başarıyla Eklendi', area: prefix});
        if (res.status !== false) {
            $.when(parseRendered(res)).then(function () {
                progressForPublish(0, prefix);
                $('input[name=name],input[name=slug]').val('');
            });
        } else {
            progressForPublish(0, prefix);
        }

    }).fail(function (res) {
        ajaxCheckStatus(res, {status: 500});
        progressForPublish(0, prefix);
        console.log(res.responseText);
    });
});

$(document).on('click', '#parentCategories', function () {
    let id = $(this).attr('data-id'),
        name = $(this).attr('data-name');
    simplePost({action: 'getParents', term_id: id, main: name + ' \'nin Alt Kategorileri'}, category, 'get').done(function (res) {
        console.log(res);
        $('#parentCategoriesContent').html(res.html).promise().done(function () {
            $('#parentCategoriesModal').modal('toggle');
        });
    }).fail(function (res) {
        console.log(res.responseText);
    })
});

function multipleDelete(variable, area) {
    $(document).on('click', variable, function () {
        $('select[name=action]').each(function () {
            if ($(this).val() == 'delete' && $(this).attr('data-area') == area) {
                let values = $(area + ' input[type=checkbox]:checked').not('[data-checkbox-role]').map(function () {
                    return this.value;
                }).get();
                if (values.length > 0) {
                    simplePost({ids: values}, category, 'delete').done(function (res) {
                        if (res.confirm) {
                            confirmParentCategories(res);
                        } else {
                            if (ajaxCheckStatus(res))
                                location.reload();
                        }

                    }).fail(function (res) {
                        ajaxCheckStatus(res, {status: 500});
                        console.log(res.responseText);
                    })
                }
            }
        });
    });
}

function singleDelete(variable) {
    $(document).on('click', variable, function () {
        if (confirm('Silmek istediğinizden emin misiniz ?')) {
            let id = $(this).attr('data-id');
            if (id.length > 0) {
                simplePost({
                    ids: id,
                }, category, 'delete').done(function (res) {
                    console.log(res);
                    if (res.confirm) {
                        confirmParentCategories(res, variable);
                    } else {
                        if (ajaxCheckStatus(res))
                            location.reload();
                    }

                }).fail(function (res) {
                    ajaxCheckStatus(res, {status: 500});
                    console.log(res.responseText);
                })
            }
        }
    })
}

function confirmParentCategories(res, variable = '') {
    if (confirm('Bu kategorinin alt kategorileri mevcut. Eğer silerseniz alt kategoriler ana kategori olarak güncellenecektir')) {
        simplePost({data: res.data, confirm: true}, category, 'delete').done(function (response) {
            console.log(response);
            parseRendered(response);
            if (variable === '#singleDeleteInParents' && res.status !== false) {
                $(variable).closest('tr').remove();
            }
            ajaxCheckStatus(res, {successMessage: 'Başarıyla Silindi', errorTitle: 'Silinemedi', errorMessage: ''});
        }).fail(function (response) {
            ajaxCheckStatus(response, {status: 500});
            console.log(response.responseText);
        });
    }
}

function parseRendered(res, reset = true) {
    if ($('#closeSearch').is(':hidden')) {
        if (reset)
            $('select[name=parent_category]').html('<option value="0">Yok</option>' + res.parents.original.html);
        $('#categories').html(res.table.original.html);
        $('#parents input[type=checkbox]:checked').not('[data-checkbox-role]').each(function () {
            $(this).closest('tr').remove();
        });
    }
}

function update(id) {
    let prefix = '.newCategory ',
        name = $(prefix + 'input[name=name]').val(),
        slug = $(prefix + 'input[name=slug]').val(),
        parent = $(prefix + 'select[name=parent_category]').val(),
        updateClass = ' #update';
    progressForPublish(1, prefix, updateClass);
    simplePost({name: name, slug: slug, parent: parent, id: id}, category, 'put').done(function (res) {
        ajaxCheckStatus(res, {successMessage: 'Kategori Başarıyla Güncellendi', area: prefix});
        console.log(res);
        if (res.status !== false) {
            $.when(parseRendered(res, false)).then(function () {
                $('.newCategory .card-header h4 span').text(name);
                progressForPublish(0, prefix, updateClass);
            });
        } else {
            progressForPublish(0, prefix, updateClass);
        }

    }).fail(function (res) {
        ajaxCheckStatus(res, {status: 500});
        progressForPublish(0, prefix, updateClass);
        console.log(res.responseText);
    });
}

multipleDelete('#deleteInTable', '#categories');
multipleDelete('#deleteInParents', '#parents');
singleDelete('#singleDeleteInTable');
singleDelete('#singleDeleteInParents');


$('#searchInCategories').keyup(function (e) {
    if (e.keyCode === 13 && $.trim($(this).val()).length > 0)
        searchInCategories($.trim($(this).val()));
});
$('#searchCategoriesBtn').on('click', function () {
    let input = $('#searchInCategories');
    if ($.trim(input.val()).length > 0)
        searchInCategories($.trim(input.val()));
});

function searchInCategories(value) {
    let url = searchInTable(value);
    window.location.href = category + url;
}