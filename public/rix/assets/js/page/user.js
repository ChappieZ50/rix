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
            progressForPublish(0, area);
            if (ajaxCheckStatus(res,{showSuccess: false})){
                if(res.content.action === 'insert')
                    window.location.href = user + "/" + res.content.user_id + "?status=success&action=insert";
                else if(res.content.action === 'update')
                    window.location.href = user + "/" + res.content.user_id + "?status=success&action=update";
            }
        }).fail(function (res) {
            progressForPublish(0, area);
            ajaxCheckStatus(res, {status: 500});
        });
    });
});
$('#resetPassword').on('click', function () {
    let auth = $(this).attr('data-auth'),
        html = '    <div class="form-group row mb-2">\n' +
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
    if (auth !== 'self') {
        if (confirm('Başka bir kullanıcının profilini güncelliyorsunuz. Bunu yapmak istediğinizden emin misin?')) {
            $(this).hide();
            $('.password_area').html(html);
        }
    } else {
        $(this).hide();
        $('.password_area').html(html);
    }
});
$('.actions a').not('#edit').on('click', function () {
    if ($(this).attr('data-target') !== 'post') {
        if (confirm('Bunu yapmak istediğinizden emin misiniz ?'))
            applySingleSelect($(this), users);
    } else {
        $('#moveAnOtherUser').attr('data-id', $(this).closest('div').attr('data-id')).modal('toggle');
        $('input[name=transferAdmin]').each(function () {
            if ($(this).val() == $('#moveAnOtherUser').attr('data-id'))
                $(this).closest('div').hide();
            else
                $(this).closest('div').show();
        });
    }
});
$('#moveUserModalActions #delete').on('click', function () {
    if (confirm('Kullanıcıyı içerikle beraber silmek istediğinizden emin misiniz ?'))
        doAction([{id: $('#moveAnOtherUser').attr('data-id')}], 'delete', users);
});
$('#moveUserModalActions #transfer').on('click', function () {
    if (confirm('İçerikleri seçtiğiniz kullanıcıya aktarmak istiyor musunuz ?')) {
        let transferID = $('input[name=transferAdmin]:checked').val(),
            deleteID = $('#moveAnOtherUser').attr('data-id');
        doAction({transferID, deleteID}, 'transfer', users);
    }
});
$('#searchInUsers').keyup(function (e) {
    if (e.keyCode === 13 && $.trim($(this).val()).length > 0)
        searchInUsers($.trim($(this).val()));
});
$('#searchInUsersBtn').on('click', function () {
    let input = $('#searchInUsers');
    if ($.trim(input.val()).length > 0)
        searchInUsers($.trim(input.val()));
});

function searchInUsers(value) {
    let url = searchInTable(value);
    window.location.href = users + url;
}