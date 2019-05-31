$(document).on('click', '#imageDetailsBtn', function () {
    let id = $(this).attr('data-id'),
        imagesData = JSON.parse(localStorage.getItem('imagesData'));
    $.each(imagesData.data, function (index, value) {
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
        }
    });
});

simplePost({action:'forGallery'}, gallery).done(function (res) {
    $('.gallery').html(res.html);
    localStorage.setItem('imagesData', JSON.stringify(res.data))
});
let page = 2,
    url = gallery + '?page=' + page;
$(document).endlessScroll({
    callback: function (){
        simplePost({action:'forGallery'},url,'get').done(function (res) {
            $('.gallery').append(res.html)
        });
    }
});