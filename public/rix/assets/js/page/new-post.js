$(document).on('click', '.newPost #publish', function () {
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
        slider = $('input[name=slider]').val()
        // ------------------------
        area = '.newPost';
    progressForPublish(1, area);
    simplePost({
        title, slug, content, summary, seo_title, seo_description, seo_keywords, featured_image,
        categories, tags, status, featured, slider
    }, post).done(function (res) {
        progressForPublish(0, area);
        if(ajaxCheckStatus(res))
            window.location.href = redirectPost + "?action=edit&id=" + res.post_id + '&status=success';
    }).fail(function (res) {
        progressForPublish(0, area);
        ajaxCheckStatus(res, {status: 500});
    });
});
