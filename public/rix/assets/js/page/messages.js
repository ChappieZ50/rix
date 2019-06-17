$('#apply').on('click', function () {
    applyMultipleSelect('messages',messages);
});
$('.actions a').on('click', function () {
    applySingleSelect($(this),messages);
});
$('#searchInMessages').keyup(function (e) {
    if (e.keyCode === 13 && $.trim($(this).val()).length > 0)
        searchInMessages($.trim($(this).val()));
});
$('#searchInMessagesBtn').on('click', function () {
    let input = $('#searchInMessages');
    if ($.trim(input.val()).length > 0)
        searchInMessages($.trim(input.val()));
});

function searchInMessages(value) {
    let url = searchInTable(value);
    window.location.href = messages + url;
}
