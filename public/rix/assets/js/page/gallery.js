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
                $('a.delete').attr('data-id', id);
                localStorage.setItem('selectedImage', JSON.stringify({id: value.image_id, data: imageData, set: i}));
            }
        });
    });
});
let set = 0;
simplePost({action: 'forGallery'}, gallery).done(function (res) {
    $('.gallery').html(res.html);
    localStorage.setItem('imagesData', JSON.stringify({0: res.data.data}));
});


let page = 2,
    url = gallery + '?page=' + page;
$(document).endlessScroll({
    callback: function () {
        simplePost({action: 'forGallery'}, url, 'get').done(function (res) {
            set = page - 1;
            $('.gallery').append(res.html);
            let stored = JSON.parse(localStorage.getItem('imagesData')),
                newImageData = {[set]: res.data.data};
            localStorage.setItem('imagesData', JSON.stringify(Object.assign(stored, newImageData)));
            page++;
        });
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
            updateSelectedImage();
        }).fail(function (res) {
            ajaxCheckStatus(res, {status: 500});
        });
    }
});

function updateSelectedImage() {
    let image = JSON.parse(localStorage.getItem('selectedImage'));
    let images = JSON.parse(localStorage.getItem('imagesData'));
    $.each(images[image.set], function (index, value) {
        if (value.image_id === image.id)
            images[image.set][index].image_data = JSON.stringify(image.data);

    });
    localStorage.setItem('imagesData', JSON.stringify(images));
}
