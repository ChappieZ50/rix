$(document).on('click', '#add_image', function () {
    $('#select_image').attr('data-position', $(this).attr('data-position'));
    if ($(this).attr('data-before') == 0) {
        let url = $(this).data('url');
        let page = 1;
        $.ajax({
            type: 'get',
            url: url + '?page=' + page,
            success: function (res) {
                let modal = $('.modal-media-items');
                modal.html(res.html);
                if (res.html.length > 0) {
                    $('#add_image').attr('data-before', 1);
                    infiniteScroll();
                    loadImageData(res.data);
                } else {
                    modal.html('<h1 class="text-center">Resim Eklenmemiş</h1>')
                }
            },
            error: function (res) {
                console.log({
                    status: 'Error',
                    response: res
                });
            }
        })
    }
});

function infiniteScroll() {
    let page = 2;
    let url = $('#add_image').data('url');
    $('.media-content').endlessScroll({
        callback: function () {
            $.ajax({
                type: 'get',
                url: url + '?page=' + page,
                success: function (res) {
                    if (res.html.length > 0) {
                        $('.modal-media-items').append(res.html);
                        page++;
                        loadImageData(res.data)
                    }
                },
                error: function (res) {
                    console.log({
                        status: 'Error',
                        response: res
                    });
                }
            });
        }
    })
}

function loadImageData(data, newUpload = false) {
    let title = $('.inputs input[name=image_title]');
    let alt = $('.inputs input[name=image_alt]');
    let content = $('.media-details .content');
    let selectImage = $('#select_image');
    $(document).on('click', '.imagecheck-input', function () {
        if ($(this).is(':checked')) {
            let radioID = $(this).val();
            $.each(data.data, function (index, value) {
                if (radioID == value.id) {
                    let image_data = $.parseJSON(value.image_data);
                    $('.details .date').text(image_data.formatedDate);
                    $('.details .size').text(image_data.imageSizeHumanReadable);
                    $('.details .pixels').text(image_data.width + "x" + image_data.height + " pixel");
                    $('#delete_image').attr('data-delete', value.id);
                    $('.content .image img').attr('src', image_data.url);
                    $('.inputs input[name=image_url]').val(image_data.url);
                    selectImage.attr('data-id', value.id);
                    selectImage.attr('data-url', image_data.url);
                    title.val(image_data.image_title);
                    alt.val(image_data.image_alt);
                    title.attr('data-id', value.id);
                    alt.attr('data-id', value.id);
                    focusoutUpdate(value.id, image_data, data, index);
                    content.show();
                }
            });
        }
    })
}

function focusoutUpdate(id, data, allData, index) {
    let inputs = $('.media-details .inputs input');
    inputs.on('focus', function () {
        $(this).attr('data-originalValue', $(this).val());
    }).on('blur', function () {
        let original = $(this).attr('data-originalValue');
        if (original != $(this).val() && id == $(this).attr('data-id')) {
            allData['data'][index]['image_data'] = updateModalData(id, data, $(this).val(), $(this).attr('name'));
        }
    })
}

function updateModalData(id, data, value, name) {
    data[name] = value;
    simplePost({
        id: id,
        data: JSON.stringify(data)
    }, update_media);
    return JSON.stringify(data);
}

$(document).on('click', '#delete_image', function () {
    if (confirm('Resmi silmek istediğinden emin misin?')) {
        let id = $(this).attr('data-delete');
        simplePost({image_id: id}, delete_image, 'delete').done(function (response) {
            if (response.status === true) {
                $('.imagecheck-input[value=' + id + ']').closest('.imagecheck-item').remove();
                $('.media-details .content').hide();
                if ($('#image-preview input[name=featured_image]').val() == id) {
                    $('#image-preview').html('');
                }
            }
        })
    }
});

$(document).on('click', '#select_image', function () {
    let id = $(this).attr('data-id');
    let url = $(this).attr('data-url');
    if ($(this).attr('data-position') == 'summernote') {
        $('.note-editable').append('<p><img src="' + url + '" style="width:50%;"></p>')
        $('.modal').modal('hide');

    } else {
        $('#image-preview').html(
            '<img src="' + url + '" />' +
            '<input type="hidden" name="featured_image" value="' + id + '" />'
        );
    }
    $('#mediaModal').modal('toggle');
});
