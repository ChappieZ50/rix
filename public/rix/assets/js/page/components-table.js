"use strict";

$(document).on('click','[data-checkboxes]',function () {
    let me = $(this);
    let meAttr = me.attr('data-checkboxes'),
        all = $('[data-checkbox="'+meAttr+'"]');
    if (me.is(':checked')) {
        all.prop('checked', true);
    } else {
        all.prop('checked', false);
    }
});
