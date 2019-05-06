<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Başlık</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control input-title">
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Url</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control input-url">
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">İçerik</label>
    <div class="col-sm-12 col-md-7">
        <textarea class="summernote" name="message"></textarea>
    </div>
</div>
<div class="form-group row mb-4">
    <div class="offset-3"></div>
    <div class="col-sm-12 col-md-7">
        <a href="javascript:;" class="btn btn-icon icon-left btn-info media-btn" data-toggle="modal" data-target="#mediaModal"><i class="far fa-image"></i> Resim Ekle</a>
    </div>
</div>
<div class="form-group">
    <div class="offset-3"></div>
    <div class="col-sm-12 col-md-7">

    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="mediaModal" aria-modal="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Galeri</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3">
                        <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="add-media-tab" data-toggle="tab" href="#add-media" role="tab" aria-controls="add-media" aria-selected="true">Resim Yükle</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="media-tab" data-toggle="tab" href="#media" role="tab" aria-controls="media" aria-selected="false">Resim Seç</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-8">
                        <div class="tab-content no-padding" id="myTab">
                            <div class="tab-pane fade show active" id="add-media" role="tabpanel" aria-labelledby="add-media-tab">
                                @section('dropzone_render',1)
                                @include('rix.layouts.components.media.new_media')
                            </div>
                            <div class="tab-pane fade media-tab" id="media" role="tabpanel" aria-labelledby="media-tab" style="overflow-y:scroll;height:400px;">
                                <div class="post-gallery-content d-flex justify-content-start flex-wrap">
                                    @if(!empty($images->toArray()['data']))
                                        @section('images_select_type','radio')
                                    @include('rix.layouts.components.media.images')
                                    @else
                                        Resim eklenmemiş.
                                    @endif
                                </div>
                                <div class="progress-gallery d-flex justify-content-center">
                                    <a href="javascript:;" class="btn disabled btn-primary btn-progress" style="width: 150px;">Progress</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script src="/rix/assets/js/page/gallery-paginate.js"></script>
    <script type="text/javascript">
        // Gallery paginate
        let galleryPaginatePrepare = {
            progress: $('.progress-gallery a'),
            content: $('.post-gallery-content'),
            route: "{{route('rix_new_post')}}",
            changeType:'radio',
            typeContent:'.post-gallery-content input[type=checkbox]'
        };
        galleryPaginate(galleryPaginatePrepare, $('.media-tab'), $('.post-gallery-content'));

        $(document).ready(function () {
            let title = $('.input-title');
            let url = $('.input-url');
            title.on('keyup', function () {
                let str = $(this).val();
                str = replaceSpecialChars(str);
                $(url).val(str);
            });

            function replaceSpecialChars(str) {
                let specialChars = [["ş", "s"], ["ğ", "g"], ["ü", "u"], ["ı", "i"], ["_", "-"],
                    ["ö", "o"], ["Ş", "S"], ["Ğ", "G"], ["Ç", "C"], ["ç", "c"],
                    ["Ü", "U"], ["İ", "I"], ["Ö", "O"], ["ş", "s"]];

                for (let i = 0; i < specialChars.length; i++)
                    str = str.replace(eval("/" + specialChars[i][0] + "/ig"), specialChars[i][1]);
                return str.toLowerCase().replace(/\s\s+/g, ' ').replace(/[^a-z0-9\s]/gi, '').replace(/[^\w]/ig, "-");
            }

            // Modal Fix modal backdrop
            $('#mediaModal').appendTo("body");
        });
    </script>
@append
@section('general_css')
    <style>
        .modal-xl {
            max-width: 70% !important;
            padding: 10px;
            margin: auto !important;
        }

        @media screen and (max-width: 1350px) {
            .modal-xl {
                max-width: 100% !important;
                margin-left: 20px !important;
            }
        }
    </style>
@append
