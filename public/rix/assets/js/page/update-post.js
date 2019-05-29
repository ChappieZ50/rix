$(document).on('click', '.updatePost #update', function () {
    // inputs
    let title = $('input[name=title]').val(),
        slug = $('input[name=slug]').val(),
        content = $('.summernote').summernote('code'),
        summary = $('textarea[name=summary]').val(),
        seo_title = $('input[name=seo_title]').val(),
        seo_description = $('textarea[name=seo_description]').val(),
        seo_keywords = $('input[name=seo_keywords]').val(),
        featured_image = $('#preview_selected_image').attr('data-id'),
        categories = $('select[name=categories]').val(),
        tags = $('input[name=tags]').val(),
        status = $('input[name=status]').val(),
        featured = $('input[name=featured]').val(),
        slider = $('input[name=slider]').val();

    progressForPublish(1, '', '#update');
    simplePost({
        action: 'update',
        id: param('id'),
        title, slug, content, summary, seo_title, seo_description, seo_keywords, featured_image,
        categories, tags, status, featured, slider

    }, posts, 'put').done(function (res) {
        progressForPublish(0, '', '#update');
        ajaxCheckStatus(res, {successMessage: 'Başarıyla Güncellendi'});
        console.log(res);
    }).fail(function (res) {
        progressForPublish(0, '', '#update');
        ajaxCheckStatus(res, {status: 500});
        console.log(res.responseText);
    });
});
