function deletePost(data, options = {}) {
    let defaults = {
        action:'toTrash',
        successMessage:'Çöpe Taşındı',
        errorTitle:'Başarısız'
    };
    options = $.extend(defaults, options);
    if (data.length > 0) {
        simplePost({
            action: options.action,
            currentType: param('type').length <= 0 ? 'open' : param('type'),
            data: data,
        }, posts, 'delete').done(function (res) {
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

function param(name) {
    return (location.search.split(name + '=')[1] || '').split('&')[0];
}

$(document).on('click', '#singleToTrash', function () {
    if (confirm('Silmek istediğinizden emin misiniz ?'))
        deletePost([{id: $(this).attr('data-id'), status: $(this).attr('data-status')}])
});
$(document).on('click','#singlePermanentlyDelete',function () {
    if (confirm('Yazıyı kalıcı olarak silmek istediğinizden emin misiniz ?'))
        deletePost($(this).attr('data-id'),{action:'deletePermanently',successMessage:'Silindi'})
});
$(document).on('click', '#multipleDelete', function () {
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
                    deletePost(data,{action:'deletePermanently',successMessage:'Silindi'});
            }
        }

    }
});
$(document).on('click', '#multipleToTrash', function () {

});

async function parseRendered(response) {
    let posts = $('#posts');
    posts.html(response);
}
