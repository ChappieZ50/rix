"use strict";
Dropzone.autoDiscover = false;
var dropzone = new Dropzone("#dropzone", {
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
            }
        });
        this.on("error", function (file, response) {
            $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response.errors.image);
        });
        this.on('queuecomplete', function () {
            let dropzone = $('#dropzone');
            if (dropzone.data('dropzone') === 1) {
                $.ajax({
                    url: '?page=' + 1,
                    type: 'get',

                }).done(function (res) {
                    let len = res.html.length;
                    if (len > 0) {
                        $('.post-gallery-content').html(res.html);
                    }
                })
            }
        })
    }
});
