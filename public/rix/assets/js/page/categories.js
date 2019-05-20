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
/**
 * This area for show parents categories
 */
$(document).on('click', '#parentCategories', function () {
    let id = $(this).attr('data-id'),
        name = $(this).attr('data-name');
    simplePost({term_id: id, main: name + ' \'nin Alt Kategorileri'}, add_category, 'get').done(function (res) {
        $('#parentCategoriesContent').html(res.html).promise().done(function () {
            $('#parentCategoriesModal').modal('toggle');
        });
    });
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
                    if (res.confirm) {
                        confirmParentCategories(res);
                    } else {
                        parseRendered(res);
                        ajaxCheckStatus(res, {successMessage: 'Başarıyla Silindi', errorTitle: 'Silinemedi'});
                    }
                    if (variable === '#singleDeleteInParents')
                        $(variable).closest('tr').remove();
                }).fail(function (res) {
                    ajaxCheckStatus(res, {status: 500});
                    console.log(res.responseText);
                })
            }
        }
    })
}

function confirmParentCategories(res) {
    if (confirm('Bu kategorinin alt kategorileri mevcut. Eğer silerseniz alt kategoriler ana kategori olarak güncellenecektir')) {
        simplePost({data: res.data, confirm: true}, add_category, 'delete').done(function (response) {
            console.log(response);

            parseRendered(response);
            ajaxCheckStatus(res, {successMessage: 'Başarıyla Silindi', errorTitle: 'Silinemedi'});
        }).fail(function (response) {
            ajaxCheckStatus(response, {status: 500});
            console.log(response.responseText);
        });
    }
}

function parseRendered(res,reset = true) {
    if(reset)
        $('select[name=parent_category]').html('<option value="0">Yok</option>' + res.parents.original.html);
    $('#categories').html(res.table.original.html);
    $('#parents input[type=checkbox]:checked').not('[data-checkbox-role]').each(function () {
        $(this).closest('tr').remove();
    });
}
function update(id){
    let prefix = '.newCategory ',
        name = $(prefix + 'input[name=name]').val(),
        slug = $(prefix + 'input[name=slug]').val(),
        parent = $(prefix + 'select[name=parent_category]').val(),
        updateClass = ' #update';
    progressForPublish(1, prefix,updateClass);
    simplePost({name: name, slug: slug, parent: parent,id:id}, add_category,'put').done(function (res) {
        ajaxCheckStatus(res, {successMessage: 'Kategori Başarıyla Güncellendi', area: prefix});
        console.log(res);
        if (res.status !== false) {
            $.when(parseRendered(res,false)).then(function () {
                progressForPublish(0, prefix,updateClass);
            });
        } else {
            progressForPublish(0, prefix,updateClass);
        }

    }).fail(function (res) {
        ajaxCheckStatus(res, {status: 500});
        progressForPublish(0, prefix,updateClass);
        console.log(res.responseText);
    });
}
multipleDelete('#deleteInTable', '#categories');
multipleDelete('#deleteInParents', '#parents');
singleDelete('#singleDeleteInTable');
singleDelete('#singleDeleteInParents');
