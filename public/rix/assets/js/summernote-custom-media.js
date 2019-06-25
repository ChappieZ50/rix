$(function () {
    let button =
        '<div class="d-flex justify-content-center align-items-center mb-4">' +
        '<button type="button" class="btn btn-primary" data-toggle="modal"' +
        ' data-target="#mediaModal" data-before="0" data-url="' + gallery + '"' +
        ' id="add_image" data-position="summernote" style="box-shadow:0;border-radius:0;width:100%;padding:10px;">Resim Seç</button>' +
        '</div>';
    let images = $('.note-group-select-from-files');
    images.html(
        button +
        '<div class="text-center"><h6>Veya</h6></div>'
    );
    $('#mediaModal').appendTo("body");
});