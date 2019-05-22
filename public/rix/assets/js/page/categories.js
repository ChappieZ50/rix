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
    simplePost({name: name, slug: slug, parent: parent}, add_category).done(function (res) {
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
    simplePost({action: 'getParents', term_id: id, main: name + ' \'nin Alt Kategorileri'}, add_category, 'get').done(function (res) {
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
                    simplePost({ids: values}, add_category, 'delete').done(function (res) {
                        if (res.confirm) {
                            confirmParentCategories(res)
                        } else {
                            ajaxCheckStatus(res, {successMessage: 'Başarıyla Silindi', errorTitle: 'Silinemedi'});
                            parseRendered(res);
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
                }, add_category, 'delete').done(function (res) {
                    console.log(res);
                    if (res.confirm) {
                        confirmParentCategories(res, variable);
                    } else {
                        parseRendered(res);
                        ajaxCheckStatus(res, {successMessage: 'Başarıyla Silindi', errorTitle: 'Silinemedi'});
                        if (variable === '#singleDeleteInParents' && res.status !== false) {
                            console.log('Remove');
                            $(variable).closest('tr').remove();
                        }
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
        simplePost({data: res.data, confirm: true}, add_category, 'delete').done(function (response) {
            console.log(response);
            parseRendered(response);
            if (variable === '#singleDeleteInParents' && res.status !== false) {
                console.log('Confirm Remove');
                $(variable).closest('tr').remove();
            }
            ajaxCheckStatus(res, {successMessage: 'Başarıyla Silindi', errorTitle: 'Silinemedi'});
        }).fail(function (response) {
            ajaxCheckStatus(response, {status: 500});
            console.log(response.responseText);
        });
    }
}

function parseRendered(res, reset = true) {
    if (reset)
        $('select[name=parent_category]').html('<option value="0">Yok</option>' + res.parents.original.html);
    $('#categories').html(res.table.original.html);
    $('#parents input[type=checkbox]:checked').not('[data-checkbox-role]').each(function () {
        $(this).closest('tr').remove();
    });
}

function update(id) {
    let prefix = '.newCategory ',
        name = $(prefix + 'input[name=name]').val(),
        slug = $(prefix + 'input[name=slug]').val(),
        parent = $(prefix + 'select[name=parent_category]').val(),
        updateClass = ' #update';
    progressForPublish(1, prefix, updateClass);
    simplePost({name: name, slug: slug, parent: parent, id: id}, add_category, 'put').done(function (res) {
        ajaxCheckStatus(res, {successMessage: 'Kategori Başarıyla Güncellendi', area: prefix});
        console.log(res);
        if (res.status !== false) {
            $.when(parseRendered(res, false)).then(function () {
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
$('#closeSearch').on('click', function () {
    closeSearch();
});

function searchInCategories(value) {
    $('#closeSearch').show();
    simplePost({action: 'search', value: value}, add_category, 'get').done(function (res) {
        $('#categoriesTable').html(res.html);
        if (res.data.data.length <= 0)
            $('#categories').after('<div class="text-center mb-3"><b><h6>Aradığınız kategori bulunamadı.</h6></b></div>');
        console.log($('#categoriesTable').html());
    }).fail(function (res) {
        console.log(res.responseText);
        ajaxCheckStatus(res, {status: 500});
    })
}

function closeSearch() {
    $('#closeSearch').hide();
    $('#searchInCategories').val('');
    simplePost({action: 'getTable'}, add_category, 'get').done(function (res) {
        console.log(res);
        $('#categoriesTable').html(res.html);
    }).fail(function (res) {
        console.log(res.responseText);
        ajaxCheckStatus(res, {status: 500});
    });
}
