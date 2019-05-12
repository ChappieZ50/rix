$('#txt_src').on('keyup', function () {
    $('#txt_trg').val(stringToSlug($(this).val()))
});
$(document).on('click', '#publish', function () {
    let progress = $('.btn-progress'),
        publish = $(this),
        name = $('input[name=name]').val(),
        slug = $('input[name=slug]').val(),
        parent = $('select[name=parent_category]').val();
    progress.show();
    publish.hide();
    simplePost({
        name: name, slug: slug, parent: parent
    }, add_category).done(function (res) {
        console.log(res);
        ajaxCheckStatus(res, {
            successMessage: 'Kategori Başarıyla Eklendi',
        });
        if (res.status !== false) {
            $('select[name=parent_category]').html(res.parents.original.html);
            $('#categories').html(res.table.original.html).promise().done(function () {
                progress.hide();
                publish.show();
                $('input[name=name],input[name=slug]').val('');
            });
        } else {
            progress.hide();
            publish.show();
        }

    }).fail(function (res) {
        ajaxCheckStatus(res, {
            status: 500
        });
        progress.hide();
        publish.show();
        console.log(res.responseText);
    });
});
$(document).on('click','#parentCategories',function () {
    let id = $(this).attr('data-id');
    let name = $(this).attr('data-name');
    simplePost({term_id:id,main:name + ' \'nin Alt Kategorileri'},add_category,'get').done(function (res) {
        console.log(res.html);
        $('#parentCategoriesContent').html(res.html).promise().done(function () {
            $(this).appendTo("body");
            $('#parentCategoriesModal').modal('toggle')
        });


    }).fail(function (res) {
        console.log(res.responseText);
    })
});
