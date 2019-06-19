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
$('#apply').on('click', function () {
    applyMultipleSelect('users',users);
});
$('.actions a').not('#edit').on('click', function () {
    if(confirm('Bunu yapmak istediğinizden emin misiniz ?'))
        applySingleSelect($(this),users);
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

