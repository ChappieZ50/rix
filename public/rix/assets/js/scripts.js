"use strict";

// ChartJS
if (window.Chart) {
    Chart.defaults.global.defaultFontFamily = "'Nunito', 'Segoe UI', 'Arial'";
    Chart.defaults.global.defaultFontSize = 12;
    Chart.defaults.global.defaultFontStyle = 500;
    Chart.defaults.global.defaultFontColor = "#999";
    Chart.defaults.global.tooltips.backgroundColor = "#000";
    Chart.defaults.global.tooltips.bodyFontColor = "rgba(255,255,255,.7)";
    Chart.defaults.global.tooltips.titleMarginBottom = 10;
    Chart.defaults.global.tooltips.titleFontSize = 14;
    Chart.defaults.global.tooltips.titleFontFamily = "'Nunito', 'Segoe UI', 'Arial'";
    Chart.defaults.global.tooltips.titleFontColor = '#fff';
    Chart.defaults.global.tooltips.xPadding = 15;
    Chart.defaults.global.tooltips.yPadding = 15;
    Chart.defaults.global.tooltips.displayColors = false;
    Chart.defaults.global.tooltips.intersect = false;
    Chart.defaults.global.tooltips.mode = 'nearest';
}

// DropzoneJS
if (window.Dropzone) {
    Dropzone.autoDiscover = false;
}

// Basic confirm box
$('[data-confirm]').each(function () {
    var me = $(this),
        me_data = me.data('confirm');

    me_data = me_data.split("|");
    me.fireModal({
        title: me_data[0],
        body: me_data[1],
        buttons: [
            {
                text: me.data('confirm-text-yes') || 'Yes',
                class: 'btn btn-danger btn-shadow',
                handler: function () {
                    eval(me.data('confirm-yes'));
                }
            },
            {
                text: me.data('confirm-text-cancel') || 'Cancel',
                class: 'btn btn-secondary',
                handler: function (modal) {
                    $.destroyModal(modal);
                    eval(me.data('confirm-no'));
                }
            }
        ]
    })
});

// Global
$(function () {
    let sidebar_nicescroll_opts = {
        cursoropacitymin: 0,
        cursoropacitymax: .8,
        zindex: 892
    }, now_layout_class = null;

    var sidebar_sticky = function () {
        if ($("body").hasClass('layout-2')) {
            $("body.layout-2 #sidebar-wrapper").stick_in_parent({
                parent: $('body')
            });
            $("body.layout-2 #sidebar-wrapper").stick_in_parent({recalc_every: 1});
        }
    }
    sidebar_sticky();

    var sidebar_nicescroll;
    var update_sidebar_nicescroll = function () {
        let a = setInterval(function () {
            if (sidebar_nicescroll != null)
                sidebar_nicescroll.resize();
        }, 10);

        setTimeout(function () {
            clearInterval(a);
        }, 600);
    }

    var sidebar_dropdown = function () {
        if ($(".main-sidebar").length) {
            $(".main-sidebar").niceScroll(sidebar_nicescroll_opts);
            sidebar_nicescroll = $(".main-sidebar").getNiceScroll();

            $(".main-sidebar .sidebar-menu li a.has-dropdown").off('click').on('click', function () {
                var me = $(this);

                $('.main-sidebar .sidebar-menu li.active > .dropdown-menu').slideUp(500, function () {
                    update_sidebar_nicescroll();
                    return false;
                });
                $('.main-sidebar .sidebar-menu li.active').removeClass('active');

                if (me.parent().hasClass("active")) {
                    me.parent().removeClass('active');

                    me.parent().find('> .dropdown-menu').slideUp(500, function () {
                        update_sidebar_nicescroll();
                        return false;
                    });
                } else {
                    me.parent().addClass('active');

                    me.parent().find('> .dropdown-menu').slideDown(500, function () {
                        update_sidebar_nicescroll();
                        return false;
                    });
                }

                return false;
            });

            $('.main-sidebar .sidebar-menu li.active > .dropdown-menu').slideDown(500, function () {
                update_sidebar_nicescroll();
                return false;
            });
        }
    }
    sidebar_dropdown();

    if ($("#top-5-scroll").length) {
        $("#top-5-scroll").css({
            height: 315
        }).niceScroll();
    }

    $(".main-content").css({
        minHeight: $(window).outerHeight() - 108
    })

    $(".nav-collapse-toggle").click(function () {
        $(this).parent().find('.navbar-nav').toggleClass('show');
        return false;
    });

    $(document).on('click', function (e) {
        $(".nav-collapse .navbar-nav").removeClass('show');
    });

    var toggle_sidebar_mini = function (mini) {
        let body = $('body');

        if (!mini) {
            body.removeClass('sidebar-mini');
            $(".main-sidebar").css({
                overflow: 'hidden'
            });
            setTimeout(function () {
                $(".main-sidebar").niceScroll(sidebar_nicescroll_opts);
                sidebar_nicescroll = $(".main-sidebar").getNiceScroll();
            }, 500);
            $(".main-sidebar .sidebar-menu > li > ul .dropdown-title").remove();
            $(".main-sidebar .sidebar-menu > li > a").removeAttr('data-toggle');
            $(".main-sidebar .sidebar-menu > li > a").removeAttr('data-original-title');
            $(".main-sidebar .sidebar-menu > li > a").removeAttr('title');
        } else {
            body.addClass('sidebar-mini');
            body.removeClass('sidebar-show');
            sidebar_nicescroll.remove();
            sidebar_nicescroll = null;
            $(".main-sidebar .sidebar-menu > li").each(function () {
                let me = $(this);

                if (me.find('> .dropdown-menu').length) {
                    me.find('> .dropdown-menu').hide();
                    me.find('> .dropdown-menu').prepend('<li class="dropdown-title pt-3">' + me.find('> a').text() + '</li>');
                } else {
                    me.find('> a').attr('data-toggle', 'tooltip');
                    me.find('> a').attr('data-original-title', me.find('> a').text());
                    $("[data-toggle='tooltip']").tooltip({
                        placement: 'right'
                    });
                }
            });
        }
    }

    $("[data-toggle='sidebar']").click(function () {
        var body = $("body"),
            w = $(window);

        if (w.outerWidth() <= 1024) {
            body.removeClass('search-show search-gone');
            if (body.hasClass('sidebar-gone')) {
                body.removeClass('sidebar-gone');
                body.addClass('sidebar-show');
            } else {
                body.addClass('sidebar-gone');
                body.removeClass('sidebar-show');
            }

            update_sidebar_nicescroll();
        } else {
            body.removeClass('search-show search-gone');
            if (body.hasClass('sidebar-mini')) {
                toggle_sidebar_mini(false);
            } else {
                toggle_sidebar_mini(true);
            }
        }

        return false;
    });

    var toggleLayout = function () {
        var w = $(window),
            layout_class = $('body').attr('class') || '',
            layout_classes = (layout_class.trim().length > 0 ? layout_class.split(' ') : '');

        if (layout_classes.length > 0) {
            layout_classes.forEach(function (item) {
                if (item.indexOf('layout-') != -1) {
                    now_layout_class = item;
                }
            });
        }

        if (w.outerWidth() <= 1024) {
            if ($('body').hasClass('sidebar-mini')) {
                toggle_sidebar_mini(false);
                $('.main-sidebar').niceScroll(sidebar_nicescroll_opts);
                sidebar_nicescroll = $(".main-sidebar").getNiceScroll();
            }

            $("body").addClass("sidebar-gone");
            $("body").removeClass("layout-2 layout-3 sidebar-mini sidebar-show");
            $("body").off('click touchend').on('click touchend', function (e) {
                if ($(e.target).hasClass('sidebar-show') || $(e.target).hasClass('search-show')) {
                    $("body").removeClass("sidebar-show");
                    $("body").addClass("sidebar-gone");
                    $("body").removeClass("search-show");

                    update_sidebar_nicescroll();
                }
            });

            update_sidebar_nicescroll();

            if (now_layout_class == 'layout-3') {
                let nav_second_classes = $(".navbar-secondary").attr('class'),
                    nav_second = $(".navbar-secondary");

                nav_second.attr('data-nav-classes', nav_second_classes);
                nav_second.removeAttr('class');
                nav_second.addClass('main-sidebar');

                let main_sidebar = $(".main-sidebar");
                main_sidebar.find('.container').addClass('sidebar-wrapper').removeClass('container');
                main_sidebar.find('.navbar-nav').addClass('sidebar-menu').removeClass('navbar-nav');
                main_sidebar.find('.sidebar-menu .nav-item.dropdown.show a').click();
                main_sidebar.find('.sidebar-brand').remove();
                main_sidebar.find('.sidebar-menu').before($('<div>', {
                    class: 'sidebar-brand'
                }).append(
                    $('<a>', {
                        href: $('.navbar-brand').attr('href'),
                    }).html($('.navbar-brand').html())
                ));
                setTimeout(function () {
                    sidebar_nicescroll = main_sidebar.niceScroll(sidebar_nicescroll_opts);
                    sidebar_nicescroll = main_sidebar.getNiceScroll();
                }, 700);

                sidebar_dropdown();
                $(".main-wrapper").removeClass("container");
            }
        } else {
            $("body").removeClass("sidebar-gone sidebar-show");
            if (now_layout_class)
                $("body").addClass(now_layout_class);

            let nav_second_classes = $(".main-sidebar").attr('data-nav-classes'),
                nav_second = $(".main-sidebar");

            if (now_layout_class == 'layout-3' && nav_second.hasClass('main-sidebar')) {
                nav_second.find(".sidebar-menu li a.has-dropdown").off('click');
                nav_second.find('.sidebar-brand').remove();
                nav_second.removeAttr('class');
                nav_second.addClass(nav_second_classes);

                let main_sidebar = $(".navbar-secondary");
                main_sidebar.find('.sidebar-wrapper').addClass('container').removeClass('sidebar-wrapper');
                main_sidebar.find('.sidebar-menu').addClass('navbar-nav').removeClass('sidebar-menu');
                main_sidebar.find('.dropdown-menu').hide();
                main_sidebar.removeAttr('style');
                main_sidebar.removeAttr('tabindex');
                main_sidebar.removeAttr('data-nav-classes');
                $(".main-wrapper").addClass("container");
                // if(sidebar_nicescroll != null)
                //   sidebar_nicescroll.remove();
            } else if (now_layout_class == 'layout-2') {
                $("body").addClass("layout-2");
            } else {
                update_sidebar_nicescroll();
            }
        }
    }
    toggleLayout();
    $(window).resize(toggleLayout);

    $("[data-toggle='search']").click(function () {
        var body = $("body");

        if (body.hasClass('search-gone')) {
            body.addClass('search-gone');
            body.removeClass('search-show');
        } else {
            body.removeClass('search-gone');
            body.addClass('search-show');
        }
    });

    // tooltip
    $("[data-toggle='tooltip']").tooltip();

    // popover
    $('[data-toggle="popover"]').popover({
        container: 'body'
    });

    // Select2
    if (jQuery().select2) {
        $(".select2").select2();
    }

    // Selectric
    if (jQuery().selectric) {
        $(".selectric").selectric({
            disableOnMobile: false,
            nativeOnMobile: false
        });
    }

    $(".notification-toggle").dropdown();
    $(".notification-toggle").parent().on('shown.bs.dropdown', function () {
        $(".dropdown-list-icons").niceScroll({
            cursoropacitymin: .3,
            cursoropacitymax: .8,
            cursorwidth: 7
        });
    });

    $(".message-toggle").dropdown();
    $(".message-toggle").parent().on('shown.bs.dropdown', function () {
        $(".dropdown-list-message").niceScroll({
            cursoropacitymin: .3,
            cursoropacitymax: .8,
            cursorwidth: 7
        });
    });

    if ($(".chat-content").length) {
        $(".chat-content").niceScroll({
            cursoropacitymin: .3,
            cursoropacitymax: .8,
        });
        $('.chat-content').getNiceScroll(0).doScrollTop($('.chat-content').height());
    }

    if (jQuery().summernote) {
        $("#summernote").summernote({
            dialogsInBody: true,
            lang: "tr-TR",
            minHeight: 250,
            toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["fontname", ["fontname"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["table", ["table"]],
                ["insert", ["link", "picture", "video"]],
                ["view", ["codeview", "help", "fullscreen"]],
            ],
        });
        $('.note-editor  .btn-fullscreen').on('click', function () {
            $('.main-sidebar').toggle();
            $('.navbar').toggle();
        });
        //$('.summernote .btn-fullscreen').remove();
        $(".summernote-simple").summernote({
            dialogsInBody: true,
            minHeight: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['para', ['paragraph']]
            ],
        });
    }

    if (window.CodeMirror) {
        $(".codeeditor").each(function () {
            let editor = CodeMirror.fromTextArea(this, {
                lineNumbers: true,
                theme: "duotone-dark",
                mode: 'javascript',
                height: 200
            });
            editor.setSize("100%", 200);
        });
    }

    // Follow function
    $('.follow-btn, .following-btn').each(function () {
        var me = $(this),
            follow_text = 'Follow',
            unfollow_text = 'Following';

        me.click(function () {
            if (me.hasClass('following-btn')) {
                me.removeClass('btn-danger');
                me.removeClass('following-btn');
                me.addClass('btn-primary');
                me.html(follow_text);

                eval(me.data('unfollow-action'));
            } else {
                me.removeClass('btn-primary');
                me.addClass('btn-danger');
                me.addClass('following-btn');
                me.html(unfollow_text);

                eval(me.data('follow-action'));
            }
            return false;
        });
    });

    // Dismiss function
    $("[data-dismiss]").each(function () {
        var me = $(this),
            target = me.data('dismiss');

        me.click(function () {
            $(target).fadeOut(function () {
                $(target).remove();
            });
            return false;
        });
    });

    // Collapsable
    $("[data-collapse]").each(function () {
        var me = $(this),
            target = me.data('collapse');

        me.click(function () {
            $(target).collapse('toggle');
            $(target).on('shown.bs.collapse', function (e) {
                e.stopPropagation();
                me.html('<i class="fas fa-minus"></i>');
            });
            $(target).on('hidden.bs.collapse', function (e) {
                e.stopPropagation();
                me.html('<i class="fas fa-plus"></i>');
            });
            return false;
        });
    });

    // Gallery
    $(".gallery .gallery-item").each(function () {
        var me = $(this);

        me.attr('href', me.data('image'));
        me.attr('title', me.data('title'));
        if (me.parent().hasClass('gallery-fw')) {
            me.css({
                height: me.parent().data('item-height'),
            });
            me.find('div').css({
                lineHeight: me.parent().data('item-height') + 'px'
            });
        }
        me.css({
            backgroundImage: 'url("' + me.data('image') + '")'
        });
    });
    if (jQuery().Chocolat) {
        $(".gallery").Chocolat({
            className: 'gallery',
            imageSelector: '.gallery-item',
        });
    }

    // Background
    $("[data-background]").each(function () {
        var me = $(this);
        me.css({
            backgroundImage: 'url(' + me.data('background') + ')'
        });
    });

    // Custom Tab
    $("[data-tab]").each(function () {
        var me = $(this);

        me.click(function () {
            if (!me.hasClass('active')) {
                var tab_group = $('[data-tab-group="' + me.data('tab') + '"]'),
                    tab_group_active = $('[data-tab-group="' + me.data('tab') + '"].active'),
                    target = $(me.attr('href')),
                    links = $('[data-tab="' + me.data('tab') + '"]');

                links.removeClass('active');
                me.addClass('active');
                target.addClass('active');
                tab_group_active.removeClass('active');
            }
            return false;
        });
    });

    // Bootstrap 4 Validation
    $(".needs-validation").submit(function () {
        var form = $(this);
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.addClass('was-validated');
    });

    // alert dismissible
    $(".alert-dismissible").each(function () {
        var me = $(this);

        me.find('.close').click(function () {
            me.alert('close');
        });
    });

    if ($('.main-navbar').length) {
    }

    // Image cropper
    $('[data-crop-image]').each(function (e) {
        $(this).css({
            overflow: 'hidden',
            position: 'relative',
            height: $(this).data('crop-image')
        });
    });

    // Slide Toggle
    $('[data-toggle-slide]').click(function () {
        let target = $(this).data('toggle-slide');

        $(target).slideToggle();
        return false;
    });

    // Dismiss modal
    $("[data-dismiss=modal]").click(function () {
        $(this).closest('.modal').modal('hide');

        return false;
    });

    // Width attribute
    $('[data-width]').each(function () {
        $(this).css({
            width: $(this).data('width')
        });
    });

    // Height attribute
    $('[data-height]').each(function () {
        $(this).css({
            height: $(this).data('height')
        });
    });

    // Chocolat
    if ($('.chocolat-parent').length && jQuery().Chocolat) {
        $('.chocolat-parent').Chocolat();
    }

    // Sortable card
    if ($('.sortable-card').length && jQuery().sortable) {
        $('.sortable-card').sortable({
            handle: '.card-header',
            opacity: .8,
            tolerance: 'pointer'
        });
    }

    // Daterangepicker
    if (jQuery().daterangepicker) {
        if ($(".datepicker").length) {
            $('.datepicker').daterangepicker({
                locale: {format: 'YYYY-MM-DD'},
                singleDatePicker: true,
            });
        }
        if ($(".datetimepicker").length) {
            $('.datetimepicker').daterangepicker({
                locale: {format: 'YYYY-MM-DD hh:mm'},
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
            });
        }
        if ($(".daterange").length) {
            $('.daterange').daterangepicker({
                locale: {format: 'YYYY-MM-DD'},
                drops: 'down',
                opens: 'right'
            });
        }
    }

    // Timepicker
    if (jQuery().timepicker && $(".timepicker").length) {
        $(".timepicker").timepicker({
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down'
            }
        });
    }
});

function ajaxCheckStatus(res, options) {
    let defaults = {
        successTitle: 'Başarılı',
        successMessage: 'Başarıyla Eklendi',
        errorTitle: 'Eklenemedi',
        errorMessage: 'Hata! Lütfen işaretlenmiş alanları doldurun.',
        status: 200,
        area: '',
        showSuccess: true,
    };
    options = $.extend(defaults, options);
    if (options.status === 500) {
        iziToast.error({
            title: 'Hata !',
            message: 'Beklenmeyen bir hata meydana geldi !',
            position: 'topRight',
        });
        return false;
    } else {
        if (res.status === false) {
            $(options.area + ' .invalid-feedback').html('');
            $.each(res.errors, function (index, value) {
                $.each(value, function (i, v) {
                    let invalidFeedback = $(options.area + ' .invalid-feedback[data-name=' + index + ']');
                    invalidFeedback.show();
                    invalidFeedback.html(v);
                });
            });
            let content = {
                title: options.errorTitle,
                message: res.message.length > 0 ? res.message : options.errorMessage,
                position: 'topRight',
            };
            iziToast.warning(content);
            return false;
        } else {
            $(options.area + ' .invalid-feedback').html('');
            if(options.showSuccess === true)
                iziToast.success({
                    title: options.successTitle,
                    message: options.successMessage,
                    position: 'topRight',
                });
            return true;
        }
    }
}

$('#closeSearch').on('click', function () {
    window.location.replace(location.pathname);
});

function param(name) {
    return (location.search.split(name + '=')[1] || '').split('&')[0];
}

function Q(url) {
    this.search = url.split('?')[1];
    this.params = {};
    this.search && this.search.split('&').forEach(pair => {
        const split = pair.split('=');
        this.params[split[0]] = split[1];
    });
}

Q.prototype.getParam = function (param) {
    return this.params[param];
};

Q.prototype.setParam = function (param, value) {
    if (!param) {
        return this.toSearch();
    }
    if (!value) {
        delete this.params[param];
        return this.toSearch();
    }
    this.params[param] = value;
    return this.toSearch();
};

Q.prototype.toSearch = function () {
    if (!this.search) {
        return '';
    }
    return '?' + Object.keys(this.params)
        .map(param => `${param}=${this.params[param]}`)
        .join('&');
};

function searchInTable(value) {
    const search = new Q(location.search);
    search.setParam('search', value);
    let params = parseParams(search.toSearch()),
        finish = [];
    $.each(params, function (i, v) {
        i = i.replace('?', '');
        if (i != 'page' && i != 'search')
            finish[i] = v;
        if (i == 'search')
            value = v
    });
    let url = Object.keys(finish).map(function (k) {
        return encodeURIComponent(k) + "=" + encodeURIComponent(finish[k]);
    }).join('&');
    if (url === '=undefined' || url === 'undefined')
        url = '?search=' + value;
    else
        url = '?' + url + '&search=' + value;
    return url;
}


function parseParams(str) {
    return str.split('&').reduce(function (params, param) {
        var paramSplit = param.split('=').map(function (value) {
            return decodeURIComponent(value.replace(/\+/g, ' '));
        });
        params[paramSplit[0]] = paramSplit[1];
        return params;
    }, {});
}

function doAction(data, action = '', url,getParam = 'status') {
    simplePost({
        data,
        currentType: param(getParam).length <= 0 ? 'all' : param(getParam),
        action
    }, url).done(function (res) {
         if (res.status !== false)
             location.reload();
    }).fail(function (res) {
        ajaxCheckStatus(res, {status: 500});
    })
}

function applyMultipleSelect(id, url, message = 'Bunu yapmak istediğinden emin misin ? ') {
    let select = $('select[name=action]'),
        value = select.val();
    if (value.length > 0) {
        if (confirm(message)) {
            let data = $('#' + id + ' input[type=checkbox]:checked').not('[data-checkbox-role]').map(function () {
                return {id: this.value, status: $(this).attr('data-status')};
            }).get();
            if (data.length > 0)
                doAction(data, value, url);
        }
    }
}

function applySingleSelect(element, url) {
    let action = element.attr('id'),
        dataID = element.closest('div').attr('data-id'),
        status = element.closest('div').attr('data-status');
    doAction([{id: dataID, status: status}], action, url);
}

function previewImage(preview) {
    var reader = new FileReader();
    reader.onload = function (e) {
        preview.attr('src', e.target.result);
        preview.show();
    };

    $("#avatar").change(function () {
        readURL(this, reader);
    });
}

function readURL(input, reader) {
    if (input.files && input.files[0])
        reader.readAsDataURL(input.files[0]);
}

function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
    }
    return url;
}