$('#apply').on('click', function () {
    let select = $('select[name=action]'),
        value = select.val();
    if (value.length > 0) {
        if (confirm('Bunu yapmak istediğinden emin misin ? ')) {
            let data = $('#comments input[type=checkbox]:checked').not('[data-checkbox-role]').map(function () {
                return {id: this.value, status: $(this).attr('data-status')};
            }).get();
            if (data.length > 0) {
                actionComment(data, value);
            }
        }
    }
});
$('.actions a').on('click', function () {
    let action = $(this).attr('id'),
        dataID = $(this).closest('div').attr('data-id'),
        status = $(this).closest('div').attr('data-status');
    actionComment([{id: dataID, status: status}], action);
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
    let url = JQUERY4U.UTIL.addParamToUrl('search', value);
    window.location.href = url;
}
var JQUERY4U = {};
(function ($, W, D) {
    JQUERY4U.UTIL =
        {
            addParamToUrl: function (param, value) {
                var result = new RegExp(param + "=([^&]*)", "i").exec(W.location.search);
                result = result && result[1] || "";
                var loc = W.location;
                var url = loc.protocol + '//' + loc.host + loc.pathname + loc.search;

                if (result == '') {
                    if (loc.search == '') {
                        url += "?" + param + '=' + value;
                    } else {
                        url += "&" + param + '=' + value;
                    }
                }
                return url;
            }
        }

})(jQuery, window, document);

function actionComment(data, action = '') {
    simplePost({
        data,
        currentType: param('status').length <= 0 ? 'all' : param('status'),
        action
    }, comments).done(function (res) {
        if (res.status !== false)
            location.reload();
    }).fail(function (res) {
        console.log(res.responseText);
        ajaxCheckStatus(res, {status: 500});
    })
}