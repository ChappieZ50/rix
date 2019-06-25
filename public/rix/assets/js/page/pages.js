$(document).ready(function () {
    $('#pageForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this),
            area = '.page';
        if ($('#preview_selected_image').attr('data-id').length > 0)
            formData.set('featured_image',$('#preview_selected_image').attr('data-id'));
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
            console.log(res);
            /*if (ajaxCheckStatus(res,{showSuccess: false})){
                if(res.content.action === 'insert')
                    window.location.href = _page + "/" + res.content.user_id + "?status=success&action=insert";
                else
                    window.location.href = _page + "/" + res.content.user_id + "?status=success&action=update";
            }*/
        }).fail(function (res) {
            console.log(res.responseText);
            progressForPublish(0, area);
            ajaxCheckStatus(res, {status: 500});
        });
    });
});