function galleryPaginate(options, win = $(window), list = $(document)) {
    let option = $.extend({
        progress: '',
        content: '',
        route: '',
        changeType: '',
        typeContent: '',
    }, options);

    let page = 1;
    let _go = true;
    win.scroll(function () {
        if (_go === true) {
            if (win.scrollTop() + win.height() >= Math.ceil(list.height() - 10)) {
                _go = false;
                page++;
                $.ajax({
                    url: option.route + '?page=' + page,
                    type: "get",
                    beforeSend: function () {
                        option.progress.show()
                    }
                }).done(function (response) {
                    if (response.html.length === 0) {
                        option.progress.remove();
                    } else {
                        option.progress.hide();
                        $(option.content).append(response.html);
                        if (option.changeType.length > 0) {
                            $(option.typeContent).each(function () {
                                $(this).attr('type', option.changeType);
                            })
                        }
                        _go = true;
                    }
                });
            }
        }
    });
}


// OLD

/*function galleryPaginate(options, win = $(window), list = $(document)) {
    let option = $.extend({
        progress: '',
        content: '',
        route: '',
        changeType: '',
        typeContent: '',
    }, options);

    let page = 1;
    win.scroll(function () {
        console.log({
            a:win.scrollTop() + win.height(),
            b:list.height(),
            c:win.scrollTop()
        });
        if (win.scrollTop() + win.height() >= list.height()) {
            page++;
            $.ajax({
                url: option.route + '?page=' + page,
                type: "get",
                beforeSend: function () {
                    option.progress.show()
                }
            }).done(function (response) {
                if (response.html.length == 0 || response.html == null) {
                    option.progress.remove();
                } else {
                    option.progress.hide();
                    $(option.content).append(response.html);
                    if (option.changeType.length > 0) {
                        $(option.typeContent).each(function () {
                            $(this).attr('type', option.changeType);
                        })
                    }
                }
            });
        }
    });
}*/
