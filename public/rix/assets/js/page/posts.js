function deletePost(data, options = {}) {
    let defaults = {
        action: 'toTrash',
        successMessage: 'Çöpe Taşındı',
        errorTitle: 'Başarısız'
    };
    options = $.extend(defaults, options);
    if (data.length > 0) {
        simplePost({
            action: options.action,
            currentType: param('type').length <= 0 ? 'open' : param('type'),
            data: data,
        }, posts, 'delete').done(function (res) {
            console.log(res);
            ajaxCheckStatus(res, {successMessage: options.successMessage, errorTitle: options.errorTitle});
            if (res.status !== false) {
                parseRendered(res.posts.original.html);
                $('#tablePagesBar').html(res.tableBar.original.html);
            }
        }).fail(function (res) {
            ajaxCheckStatus(res, {status: 500});
            console.log(res.responseText);
        })
    }
}

function restore(data) {
    if (data.length > 0) {
        simplePost({
            action: 'restore',
            currentType: param('type').length <= 0 ? 'open' : param('type'),
            data: data,
        }, posts, 'put').done(function (res) {
            ajaxCheckStatus(res, {successMessage: 'Yazı Geri Yüklendi', errorTitle: 'Yazı Geri Yüklenemedi'});
            if (res.status !== false) {
                parseRendered(res.posts.original.html);
                $('#tablePagesBar').html(res.tableBar.original.html);
            }
        }).fail(function (res) {
            ajaxCheckStatus(res, {status: 500});
            console.log(res.responseText);
        })
    }
}

$(document).on('click', '#singleToTrash', function () {
    if (confirm('Silmek istediğinizden emin misiniz ?'))
        deletePost([{id: $(this).attr('data-id'), status: $(this).attr('data-status')}])
});
$(document).on('click', '#singlePermanentlyDelete', function () {
    if (confirm('Yazıyı kalıcı olarak silmek istediğinizden emin misiniz ?'))
        deletePost($(this).attr('data-id'), {action: 'deletePermanently', successMessage: 'Silindi'})
});
$(document).on('click', '#apply', function () {
    let select = $('select[name=action]');
    if (select.val() === 'trash' || select.val() === 'delete' && select.attr('data-area') === '#posts') {
        if (confirm('Yazıyı kalıcı olarak silmek istediğinizden emin misiniz ?')) {
            let data = $('#posts input[type=checkbox]:checked').not('[data-checkbox-role]').map(function () {
                return select.val() === 'delete' ? this.value : {id: this.value, status: $(this).attr('data-status')};
            }).get();
            if (data.length > 0) {
                if (select.val() === 'trash')
                    deletePost(data);
                else if (select.val() === 'delete')
                    deletePost(data, {action: 'deletePermanently', successMessage: 'Silindi'});
            }
        }
    } else if (select.val() === 'restore' && select.attr('data-area') === '#posts') {
        let data = $('#posts input[type=checkbox]:checked').not('[data-checkbox-role]').map(function () {
            return this.value;
        }).get();
        if (data.length > 0) {
            restore(data)
        }
    }
});
$(document).on('click', '#restore', function () {
    let id = $(this).attr('data-id');
    restore(id)
});

$('#searchInPosts').keyup(function (e) {
    if (e.keyCode === 13 && $.trim($(this).val()).length > 0)
        searchInPosts($.trim($(this).val()));
});
$('#searchPostsBtn').on('click', function () {
    let input = $('#searchInPosts');
    if ($.trim(input.val()).length > 0)
        searchInPosts($.trim(input.val()));
});
function searchInPosts(value) {
    let url = searchInTable(value);
    window.location.href = posts + url;
}
function parseRendered(response) {
    let posts = $('#posts');
    posts.html(response);
}

