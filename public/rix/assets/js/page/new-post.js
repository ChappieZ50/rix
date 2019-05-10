$(document).on('click', '#publish', function () {
    let progress = $('.btn-progress');
    let publish = $(this);
    publish.hide();
    progress.show();
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
        slider = $('input[name=slider]').val();
    /*    console.log({
            title: title,
            slug: slug,
            content: content,
            summary: summary,
            seo_title: seo_title,
            seo_description: seo_description,
            seo_keywords: seo_keywords,
            featured_image: featured_image,
            categories: categories,
            tags: tags,
            status: status,
            featured: featured,
            slider: slider
        });*/
    simplePost({
        title, slug, content, summary, seo_title, seo_description, seo_keywords, featured_image,
        categories, tags, status, featured, slider
    }, add_post).done(function (res) {
        progress.hide();
        publish.show();
        if (res.status === false) {
            $('.invalid-feedback').html('');
            $.each(res.errors, function (index, value) {
                $.each(value, function (i, v) {
                    let invalidFeedback = $('.invalid-feedback[data-name=' + index + ']');
                    invalidFeedback.show();
                    invalidFeedback.html(v);
                });
            });
             iziToast.warning({
                 title: 'Yazı Eklenemedi',
                 message: 'Hata! Lütfen işaretlenmiş alanları doldurun.',
                 position: 'topRight',
             });
        } else {
            iziToast.success({
                title: 'Yazı Başarıyla Eklendi.',
                message: res.message,
                position: 'topRight',
            });
        }
    });
});
