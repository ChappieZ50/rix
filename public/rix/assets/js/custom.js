"use strict";
// Gallery - Delete Selected
let button = $('.delete_selected');
let data = [];

function hideShowButton(a) {
    if (a > 0) {
        button.show();
        $('.delete_selected .badge').text(a);
        showSticky();
    } else {
        button.hide();
        hideSticky();
        $('.delete_selected .badge').text(0);
    }
}

function findChecked() {
    $(document).on('change', '.imagecheck-input', function () {
        data = [];
        $('.imagecheck-input').each(function (i, v) {
            let item = $(this).val();
            if ($(this).is(':checked')) {
                data.push(item);
            } else {
                data = $.grep(data, function (value) {
                    return value !== item;
                });
            }
        });
        hideShowButton(data.length);
    });
}

findChecked();

function sendDelete(data) {
    $.ajax({
        url: '',
        type: 'delete',
        data: {image_id: data},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status === true) {
                let item = $('.gallery-image-item');
                $.each(data, function (index, value) {
                    $('.imagecheck-input').each(function () {
                        if ($(this).val() === value) {
                            $(this).closest(item).remove();
                        }
                    });
                });
                iziToast.success({
                    title: 'Başarılı',
                    message: response.message,
                    position: 'topRight',
                });
            } else {
                iziToast.error({
                    title: 'Başarısız',
                    message: response.message,
                    position: 'topRight',
                });
            }
        },
        error: function (response) {
            iziToast.error({
                title: 'Başarısız',
                message: response.message,
                position: 'topRight',
            });
        }
    })
}

button.on('click', function () {
    if (confirm('Seçilen resimleri silmek istiyor musunuz?'))
        sendDelete(data);
    $('.delete_selected .badge').text(0);
    $(this).hide();
});
