localStorage.removeItem('selectedImage');
$(document).on('click', '#imageDetailsBtn', function () {
    let id = $(this).attr('data-id'),
        setS = JSON.parse(localStorage.getItem('imagesData'));
    $.each(setS, function (i, v) {
        $.each(v, function (index, value) {
            if (value.image_id == id) {
                let imageData = JSON.parse(value.image_data);
                $('#imageSrc').attr('src', imageData.url);
                $('.filename span').html(imageData.image_title.length > 0 ? imageData.image_title : '-');
                $('.file-type span').html(imageData['mime-type']);
                $('.uploaded span').html(imageData.formatedDate);
                $('.file-size span').html(imageData.imageSizeHumanReadable);
                $('.dimensions span').html(imageData.width + "x" + imageData.height + " pixel");
                $('input[name=image_url]').val(imageData.url);
                $('input[name=image_title]').val(imageData.image_title);
                $('input[name=image_alt]').val(imageData.image_alt);
                localStorage.setItem('selectedImage', JSON.stringify({id: value.image_id, data: imageData, set: i}));
            }
        });
    });
});
$(document).on('click', '.actions .delete', function () {
    let images = JSON.parse(localStorage.getItem('imagesData')),
        selectedImage = JSON.parse(localStorage.getItem('selectedImage'));
    if (confirm('Kalıcı olarak silmek istiyor musunuz ?')) {
        simplePost({image_id: selectedImage.id}, delete_image, 'delete').done(function (res) {
            ajaxCheckStatus(res, {successMessage: 'Başarıyla Silindi'});
            $.each(images[selectedImage.set], function (index, value) {
                if (value.image_id == selectedImage.id)
                    delete images[selectedImage.set][index];
            });
            images = JSON.stringify({
                [selectedImage.set]: images[selectedImage.set].filter(function () {
                    return true
                })
            });
            $('#imageDetails').modal('hide');
            localStorage.setItem('imagesData', images);
            localStorage.removeItem('selectedImage');
            $('.media-details-btn[data-id=' + selectedImage.id + ']').remove();
        }).fail(function (res) {
            ajaxCheckStatus(res, {status: 500});
        })
    }
});
let set = 0;
simplePost({action: 'forGallery'}, gallery).done(function (res) {
    if(res.html.length > 0){
        $('.gallery').html(res.html);
        localStorage.setItem('imagesData', JSON.stringify({0: res.data.data}));
    }else{
        $('.gallery').html('Resim eklenmemiş');
    }
});

let page = 2,
    scrollLoad = true;
$(document).endlessScroll({
    callback: function () {
        if (scrollLoad) {
            let url = gallery + '?page=' + page;
            simplePost({action: 'forGallery'}, url, 'get').done(function (res) {
                set = page - 1;
                $('.gallery').append(res.html);
                let stored = JSON.parse(localStorage.getItem('imagesData')),
                    newImageData = {[set]: res.data.data};
                localStorage.setItem('imagesData', JSON.stringify(Object.assign(stored, newImageData)));
                if (res.data.last_page <= page)
                    scrollLoad = false;
                page++;
                changeSelectType();
            });
        }
    }
});

$('.image-details-area .inputs input').on('focus', function () {
    $(this).attr('data-originalValue', $(this).val());
}).on('blur', function () {
    let image = JSON.parse(localStorage.getItem('selectedImage')),
        name = $(this).attr('name');
    image.data[name] = $('input[name=' + name + ']').val();
    localStorage.setItem('selectedImage', JSON.stringify(image));
    if ($(this).attr('data-originalValue') != $(this).val()) {
        simplePost({
            id: image.id,
            data: JSON.stringify(image.data)
        }, update_media).done(function () {
            if (name === 'image_title')
                $('.details .filename span').text(image.data[name]);
            updateSelectedImage();
        }).fail(function (res) {
            ajaxCheckStatus(res, {status: 500});
        });
    }
});
$('#bulk_select').on('click', function () {
    $(this).hide();
    $('.bulk-select-group').show();
    changeSelectType();
});
$('#dismiss').on('click', function () {
    $('.bulk-select-group').hide();
    $('#bulk_select').show();
    changeSelectType();
});
$('#delete_selected').on('click', function () {
    let data = [],
        progress = $('#delete_selected_progress'),
        delete_selected = $('#delete_selected');
    $('input[name=imagecheck]:checked').each(function () {
        data.push($(this).val());
    });
    if(data.length > 0){
        if (confirm('Kalıcı olarak silmek istiyor musunuz ?')) {
            progress.show();
            delete_selected.hide();
            simplePost({image_id: data}, delete_image, 'delete').done(function (res) {
                if (res.status !== false) {
                    location.reload();
                } else {
                    progress.show();
                    delete_selected.hide();
                    ajaxCheckStatus(res, {successMessage: 'Başarıyla Silindi'});
                }
            }).fail(function (res) {
                progress.hide();
                delete_selected.show();
                ajaxCheckStatus(res, {status: 500});
            });
        }
    }
});

function changeSelectType() {
    let imageCheck = $('input[name=imagecheck]'),
        detailsBtn = $('button[name=imageDetailsBtn]');
    if ($('.bulk-select-group').is(':visible')) {
        imageCheck.attr('type', 'checkbox');
        detailsBtn.attr('data-toggle', '');
    } else {
        imageCheck.attr('type', 'hidden');
        detailsBtn.attr('data-toggle', 'modal');
    }
}

function updateSelectedImage() {
    let image = JSON.parse(localStorage.getItem('selectedImage'));
    let images = JSON.parse(localStorage.getItem('imagesData'));
    $.each(images[image.set], function (index, value) {
        if (value.image_id === image.id)
            images[image.set][index].image_data = JSON.stringify(image.data);

    });
    localStorage.setItem('imagesData', JSON.stringify(images));
}
