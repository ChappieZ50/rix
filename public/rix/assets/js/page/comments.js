$('#apply').on('click', function () {
    applyMultipleSelect('comments',comments);
});
$('.actions a').on('click', function () {
    applySingleSelect($(this),comments);
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