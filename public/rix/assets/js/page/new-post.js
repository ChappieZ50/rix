$(document).on('click', '#publish', function () {
    // inputs
    let title = $('input[name=title]').val(),
        slug = $('input[name=slug]').val(),
        content = $('.summernote').summernote('code'),
        summary = $('textarea[name=summary]').val(),
        seo_title = $('input[name=seo_title]').val(),
        seo_description = $('textarea[name=seo_description]').val(),
        seo_keywords = $('input[name=seo_keywords]').val(),
        featured_image = $('input[name=featured_image]').val(),
        categories = $('select[name=categories]').val(),
        tags = $('input[name=tags]').val(),
        status = $('input[name=status]').val(),
        featured = $('input[name=featured]').val(),
        slider = $('input[name=slider]').val(),
        // ------------------------
        progress = $('.btn-progress'),
        publish = $(this);

    publish.hide();
    progress.show();
    simplePost({
        title, slug, content, summary, seo_title, seo_description, seo_keywords, featured_image,
        categories, tags, status, featured, slider
    }, add_post).done(function (res) {
        progress.hide();
        publish.show();
        ajaxCheckStatus(res, {
            successMessage:  'Yazı Başarıyla Eklendi',
        });
    }).fail(function (res) {
        ajaxCheckStatus(res, {
            status:500
        });
    });
});
