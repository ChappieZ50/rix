$(document).ready(function () {
    $('#pageForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this),
            area = '.page';
        formData.set('featured_image', $('#preview_selected_image').attr('data-id'));
        formData.set('content', $('.summernote').summernote('code'));
        progressForPublish(1, area);
        $.ajax({
            type: 'post',
            url: _page,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function (res) {
            progressForPublish(0, area);
            if (ajaxCheckStatus(res, {showSuccess: false})) {
                if (res.content.action === 'insert')
                    window.location.href = _page + "/" + res.content.page_id + "?status=success&action=insert";
                else if (res.content.action === 'update')
                    window.location.href = _page + "/" + res.content.page_id + "?status=success&action=update";
            }
        }).fail(function (res) {
            progressForPublish(0, area);
            ajaxCheckStatus(res, {status: 500});
        });
    });
});
$('.actions a').not('#edit').on('click', function () {
    if (confirm('Bunu yapmak istediğinizden emin misiniz ?'))
        applySingleSelect($(this), _pages);
});
$('#searchInPages').keyup(function (e) {
    if (e.keyCode === 13 && $.trim($(this).val()).length > 0)
        searchInPages($.trim($(this).val()));
});
$('#searchInPagesBtn').on('click', function () {
    let input = $('#searchInPages');
    if ($.trim(input.val()).length > 0)
        searchInPages($.trim(input.val()));
});

function searchInPages(value) {
    let url = searchInTable(value);
    window.location.href = _pages + url;
}