$(document).ready(function () {
    $('#profileForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this),
            area = '.profile';
        if ($('#avatar').val().length <= 0)
            formData.delete('avatar');
        progressForPublish(1, area);
        $.ajax({
            type: 'post',
            url: profile,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function (res) {
            console.log(res);
            progressForPublish(0, area);
            if (ajaxCheckStatus(res,{showSuccess: false}))
                window.location.href = profile + "?status=success";
        }).fail(function (res) {
            console.log(res.responseText);
            progressForPublish(0, area);
            ajaxCheckStatus(res, {status: 500});
        });
    });
});
$('#resetPassword').on('click', function () {
    let html = '    <div class="form-group row mb-2">\n' +
        '        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Şifre</label>\n' +
        '        <div class="col-sm-12 col-md-7">\n' +
        '            <input type="password" class="form-control" name="password">\n' +
        '            <div class="invalid-feedback" data-name="password"></div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '    <div class="form-group row mb-2">\n' +
        '        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Şifre Tekrar</label>\n' +
        '        <div class="col-sm-12 col-md-7">\n' +
        '            <input type="password" class="form-control" name="password_confirmation">\n' +
        '            <div class="invalid-feedback" data-name="password_confirmation"></div>\n' +
        '        </div>\n' +
        '    </div>';
    $(this).hide();
    $('.password_area').html(html);
});