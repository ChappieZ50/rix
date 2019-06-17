$(document).ready(function () {
    $('#userForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this),
            area = '.newUser';
        if ($('#avatar').val().length <= 0)
            formData.delete('avatar');
        progressForPublish(1, area);
        $.ajax({
            type: 'post',
            url: user,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function (res) {
            console.log(res);
            progressForPublish(0, area);
            if (ajaxCheckStatus(res))
                window.location.href = users;
        }).fail(function (res) {
            console.log(res.responseText);
            progressForPublish(0, area);
            ajaxCheckStatus(res, {status: 500});
        });
    });

});