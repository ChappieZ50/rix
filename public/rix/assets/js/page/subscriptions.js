$('#apply').on('click', function () {
    applyMultipleSelect('subscriptions',subscriptions)
});
$('.actions a').on('click', function () {
    if(confirm('Bunu yapmak istediğinizden emin misiniz ?')){
        applySingleSelect($(this),subscriptions)
    }
});
$('#searchInSubscriptions').keyup(function (e) {
    if (e.keyCode === 13 && $.trim($(this).val()).length > 0)
        searchInSubscriptions($.trim($(this).val()));
});
$('#searchInSubscriptionsBtn').on('click', function () {
    let input = $('#searchInSubscriptions');
    if ($.trim(input.val()).length > 0)
        searchInSubscriptions($.trim(input.val()));
});
function searchInSubscriptions(value) {
    let url = searchInTable(value);
    window.location.href = subscriptions + url;
}