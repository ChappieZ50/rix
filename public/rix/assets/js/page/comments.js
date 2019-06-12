$('#apply').on('click', function () {
    let select = $('select[name=action]'),
        value = select.val();
    if (value.length > 0) {
        if (confirm('Bunu yapmak istediğinden emin misin ? ')) {
            let data = $('#comments input[type=checkbox]:checked').not('[data-checkbox-role]').map(function () {
                return {id: this.value, status: $(this).attr('data-status')};
            }).get();
            if (data.length > 0) {
                doAction(data, value,comments);
            }
        }
    }
});
$('.actions a').on('click', function () {
    let action = $(this).attr('id'),
        dataID = $(this).closest('div').attr('data-id'),
        status = $(this).closest('div').attr('data-status');
    doAction([{id: dataID, status: status}], action,comments);
});
$('#searchInComments').keyup(function (e) {
    if (e.keyCode === 13 && $.trim($(this).val()).length > 0)
        searchInComments($.trim($(this).val()));
});
$('#searchCommentBtn').on('click', function () {
    let input = $('#searchInComments');
    if ($.trim(input.val()).length > 0)
        searchInComments($.trim(input.val()));
});
function searchInComments(value) {
    let url = searchInTable(value);
    window.location.href = comments + url;
}