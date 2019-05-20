"use strict";
Dropzone.autoDiscover = false;
new Dropzone("#dropzone", {
    dictDefaultMessage: "Yüklemek istediğiniz resmi sürükleyin veya seçin",
    dictFallbackMessage: "Tarayıcınız sürükle bırak eklentisini desteklemiyor.",
    dictFileTooBig: "Dosya çok büyük ({{filesize}}MiB). Maximum : {{maxFilesize}}MiB.",
    dictInvalidFileType: "Bu uzantıda dosya yükleyemezsiniz.",
    dictResponseError: "Sunucu şu kod ile yanıt verdi {{statusCode}}.",
    dictCancelUpload: "Yüklemeyi iptal et",
    dictUploadCanceled: "Yükleme iptal edildi.",
    dictCancelUploadConfirmation: "Yüklemeyi iptal etmek istediğinizden emin misiniz?",
    dictRemoveFile: "Dosyayı Sil",
    dictMaxFilesExceeded: "Daha fazla dosya yükleyemezsiniz.",
    url: route,
    maxFilesize: 3,
    maxFiles: 20,
    paramName: 'image',
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    init: function () {
        this.on("success", function (file, response) {
            if (response.status === false) {
                $(file.previewElement).removeClass("dz-success");
                $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response.message);
            } else {
                let decode = $.parseJSON(response.data.image_data);
                $('.modal-media-items h1').hide();
                $('.modal-media-items').prepend(
                    '<div class="imagecheck-item">' +
                    '<label class="imagecheck mb-4">' +
                    '<input name="imagecheck" type="radio" value="' + response.data.id + '" class="imagecheck-input" />' +
                    '<figure class="imagecheck-figure">' +
                    '<img src="' + decode.url + '" class="imagecheck-image">' +
                    '</figure>' +
                    '</label>' +
                    '</div>'
                );
                loadImageData({data:response});
            }
        });
        this.on("error", function (file, response) {
            $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response);
        });
    }
});
